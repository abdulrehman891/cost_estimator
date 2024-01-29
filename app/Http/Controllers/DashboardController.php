<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Http\Controllers\QuotationController;
use App\Models\ProjectMilestone;
use App\Models\Quotation;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        //add the reports queries
        $pending_quotes = Quotation::whereIn('status', [0, 2])->count();
        $signed_quotes = Quotation::where('status', '=', 1)->count();
        $all_quotes = $pending_quotes + $signed_quotes;
        $completed_percentage = round(($signed_quotes / $all_quotes) * 100, 2);
        $quotes_counter_by_status = Quotation::selectRaw('status, COUNT(*) as count')->groupBy('status')->get();
        $quotation_obj = new QuotationController();
        //quotations report based on Status
        $status_labels = $quotation_obj->status_list;
        $status_colors = array('#3E97FF', '#50CD89', '#FFC700', '#F1416C', '#7239EA', '#F1516B', '#7439EB');
        $quote_status_based_report_data = array(
            'label' => array(),
            'colors' => array(),
            'count' => array(),
            'percentage' => array(),
            'all_counter' => 0,
            'max_counter' => 0,
        );

        $status_from_db = array();
        $all_counter = 0;
        $max_counter = 0;
        foreach ($quotes_counter_by_status as $status_data) {
            $status_from_db[$status_data['status']] = $status_data['count'];
            $all_counter += $status_data['count'];
            $max_counter = ($max_counter > $status_data['count']) ? $max_counter : $status_data['count'];
        }
        $quote_status_based_report_data['all_counter'] = $all_counter;
        $quote_status_based_report_data['max_counter'] = $max_counter;
        foreach ($status_labels as $key => $status) {
            $quote_status_based_report_data['label'][] = $quotation_obj->status_list[$key];
            $quote_status_based_report_data['status'][] = $key;
            $quote_status_based_report_data['colors'][] = $status_colors[$key];
            if (empty($status_from_db[$key])) {
                $quote_status_based_report_data['count'][] = 0;
                $quote_status_based_report_data['percentage'][] = 0;
            } else {
                $quote_status_based_report_data['count'][] = $status_from_db[$key];
                $quote_status_based_report_data['percentage'][] = round(($status_from_db[$key] / $all_counter) * 100, 2);
            }
        }
        //all customers
        $all_customers = Customer::count();
        //get quotes by type
        $quotes_completed_residential = Quotation::join('projects', 'projects.id', '=', 'quotations.project_id')
            ->join('customers', 'customers.id', '=', 'quotations.customer_id')
            ->where('status', '=', 1)->select('customers.name as customer_name', 'projects.project_type', 'projects.name AS project_name', 'quotations.prepared_date')->where('projects.project_type', '=', 'residential')->skip(0)->take(10)->orderBy('projects.created_at')->get();
        $quotes_completed_commercial = Quotation::join('projects', 'projects.id', '=', 'quotations.project_id')
            ->join('customers', 'customers.id', '=', 'quotations.customer_id')
            ->where('status', '=', 1)->select('customers.name as customer_name', 'projects.project_type', 'projects.name AS project_name', 'quotations.prepared_date')->where('projects.project_type', '=', 'commercial')->skip(0)->take(10)->orderBy('projects.created_at')->get();
        $quotes_completed_industrial = Quotation::join('projects', 'projects.id', '=', 'quotations.project_id')
            ->join('customers', 'customers.id', '=', 'quotations.customer_id')
            ->where('status', '=', 1)->select('customers.name as customer_name', 'projects.project_type', 'projects.name AS project_name', 'quotations.prepared_date')->where('projects.project_type', '=', 'industrial')->skip(0)->take(10)->orderBy('projects.created_at')->get();
        $completed_quotes_by_type = array(
            'commercial' => $quotes_completed_commercial,
            'residential' => $quotes_completed_residential,
            'industrial' => $quotes_completed_industrial,
        );
        return view('pages/dashboards.index', compact('completed_quotes_by_type', 'all_customers', 'quote_status_based_report_data', 'quotes_counter_by_status', 'pending_quotes', 'signed_quotes', 'all_quotes', 'completed_percentage'));
    }
}
