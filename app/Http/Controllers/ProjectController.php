<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectsDataTable;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectsDataTable $projectsDataTable)
    {
        $user = auth()->user();
        if($user->can('view projects')){
            return $projectsDataTable->render('pages/apps.project.list');
        } else {
            return Redirect::to('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $project)
    {
        $user = auth()->user();
        if($user->can('view projects')){
            $project = Project::with('user')->find($project->id);
            return view('pages/apps.project.show', compact('project'));
        } else {
            return Redirect::to('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
