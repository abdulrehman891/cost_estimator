<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SendNotification;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\DataTables\NotificationDataTable;

class NotificationController extends Controller
{
    public function indexOld()
    {
        //delete the older records
        // Assuming you want to keep records from the last week
        $notification_auto_deletion_days = (!empty(env('NOTIFICATION_AUTO_DELETION_DAYS'))) ? env('NOTIFICATION_AUTO_DELETION_DAYS') : 7;
        $oneWeekAgo = now()->subDays($notification_auto_deletion_days);
        DB::table('notifications')->whereNotNull('read_at')->where('read_at', '<', $oneWeekAgo)->delete();
        //list the data
        $lims_notification_all = DB::table('notifications')->where('notifiable_id', '=', Auth::id())->orderBy('updated_at', 'DESC')->get();
        return view('pages.apps.notification.list', compact('lims_notification_all'));
        //return $quotationDataTable->render('pages/apps.quotation.list', compact('lims_notification_all'));
    }
    public function index(NotificationDataTable $notificationDataTable)
    {
        return $notificationDataTable->render('pages/apps.notification.list');
    }
    public function store(Request $request)
    {
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = date('Ymdhis') . '.' . $document->getClientOriginalExtension();
            $document->move('public/documents/notification', $documentName);
            $request->document_name = $documentName;
        }
        $user = User::find($request->receiver_id);
        $user->notify(new SendNotification($request));
        return redirect()->back()->with('message', 'Notification send successfully');
    }

    public function sendMoudleNotification($sender_id, $receiver_id, $reminder_date, $record_module, $record_id, $parent_module, $parent_id, $parent_ref_number, $record_ref_number, $message, $message_rtl, $status_code, $status_msg)
    {
        $request = new Request();
        $request->merge([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'reminder_date' => $reminder_date,
            'document_name' => "",
            'message' => $message,
            'message_rtl' => base64_encode($message_rtl),
            'record_module' => $record_module,
            'record_id' => $record_id,
            'parent_module' => $parent_module,
            'parent_id' => $parent_id,
            'parent_ref_number' => $parent_ref_number,
            'record_ref_number' => $record_ref_number,
            'status_code' => $status_code,
            'status_msg' => $status_msg,
        ]);
        //return route('records.show', ['recordType' => $this->request->record_type, 'recordId' => $this->request->record_id]);
        $user = User::find($receiver_id);
        $user->notify(new SendNotification($request));
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->where('data.reminder_date', date('Y-m-d'))->markAsRead();
    }
}
