<?php

namespace App\Http\Controllers;
use App\Journal;
use App\Client;

use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $clientId = request()->client;
        $client = Client::where('id', $clientId)
            ->where('user_id', $userId)
            ->first();
        $journals = Journal::where('client_id', $client->id)->get();

        return view('clients.journals.index', [
            'client' => $client, 
            'journals' => $journals
        ]);
    }

    public function store(Request $request)
    {
        $journal = new Journal;
        $journal->notes = $request->get('notes');

        $userId = auth()->user()->id;
        $clientId = request()->client;
        $client = Client::where('id', $clientId)
            ->where('user_id', $userId)
            ->first();
        $journal->client_id = $client->id;

        $journal->save();

        return $journal;
    }

    public function destroy()
    {
        $userId = auth()->user()->id;
        $clientId = request()->client;
        $client = Client::where('id', $clientId)
            ->where('user_id', $userId)
            ->first();
        $journalId = request()->journal;
        $journal = Journal::where('id', $journalId)
            ->where('client_id', $client->id)
            ->first();
        if ($journal) {
            $journal->delete();
            return 'Deleted';
        }

        return 'Not found';
    }

    public function create()
    {
        $userId = auth()->user()->id;
        $clientId = request()->client;
        $client = Client::where('id', $clientId)
            ->where('user_id', $userId)
            ->first();
        return view('clients.journals.create', [
            'client' => $client
        ]);
    }
}
