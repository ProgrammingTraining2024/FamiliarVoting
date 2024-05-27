<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreElectionRequest;
use App\Http\Resources\ElectionResource;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Election $election)
    {
        return inertia('Admin/Overview/index', [
            'election' => $election->id,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $election = Election::query()->orderBy('election_name', 'asc')->get();

        return Inertia('Admin/election/CreateElection', [
            ElectionResource::collection($election),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreElectionRequest $request)
    {
        $data = $request->validated();

        $data['admin_id'] = Auth::id();

        Election::create($data);

        return to_route('admin.election.index')->with('success', 'Election created success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Election $election)
    {
        return Inertia('Admin/Overview/index', [
            'election' => $election->id,
            'success' => session('success'),
        ]);
    }

    public function showVoters(Election $election)
    {
        return Inertia('Admin/Voters/index', [
            'election' => new ElectionResource($election),
            'success' => session('success'),
        ]);
    }

    public function launchElection(Request $request, Election $election)
    {
        $election->update(['status' => 'scheduling']);

        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Election $election)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Election $election)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Election $election)
    {
        //
    }
    
    public function updateElectionStatus(Election $election)
    {
       $currentDate = Carbon::now();

        $status = $election->status;
        $startDate = Carbon::parse($election->start_date);
        $endDate = Carbon::parse($election->end_date);

        if ($status === 'scheduling' && ($currentDate->greaterThanOrEqualTo($startDate) && $endDate->isFuture())) {
            $election->update(['status' => 'running']);
            // $election->update()が実行された後に$statusを更新する
            $status = 'running';
            dd($status);
        } else if ($status === 'running' && ($currentDate->greaterThanOrEqualTo($endDate) || $endDate->isPast())) {
            $election->update(['status' => 'closed']);
            // 同様に$statusを更新する
            $status = 'closed';
        }

        // return $election;

     }
}