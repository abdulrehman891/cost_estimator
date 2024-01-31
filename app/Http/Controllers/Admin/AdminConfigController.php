<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminConfigsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminConfig;
use Illuminate\Support\Facades\Redirect;

class AdminConfigController extends Controller
{
    // public function index()
    // {
    //     $configurations = AdminConfig::all();
    //     return view('pages/appsadmin.config.', compact('configurations'));
    // }


    /**
     * Display a listing of the resource.
     */
    public function index(AdminConfigsDataTable $adminConfigDataTable)
    {
        //
        $user = auth()->user();
        if($user->can('view admin configs')){
            return $adminConfigDataTable->render('pages/apps.admin.configs.list');
        } else {
            return Redirect::to('dashboard');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $adminConfig)
    {
        //
        $user = auth()->user();
        if($user->can('view admin configs')){
            $adminConfig = AdminConfig::with('user')->find($adminConfig->id);
            return view('pages/apps.admin.configs.show', compact('adminConfig'));
        } else {
            return Redirect::to('dashboard');
        }
    }

    public function getAllPrompts()
    {
        $adminPrompts = AdminConfig::with('user')->get();
        $all_prompts = [];
        foreach($adminPrompts as $prompt_data){
            $all_prompts[$prompt_data->key] = $prompt_data->value;
        }
        return $all_prompts;
    }

    public function getAiPrompts()
    {
        $adminAiPrompts = AdminConfig::with('user')->where("for_ai_prompt","=","1")->get();
        $all_ai_prompts = [];
        foreach($adminAiPrompts as $ai_prompt){
            $all_ai_prompts[$ai_prompt->key] = $ai_prompt->value;
        }
        return $all_ai_prompts;
    }
}
