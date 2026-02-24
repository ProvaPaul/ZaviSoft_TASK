<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;

/**
 * JournalEntryController
 *
 * Displays all journal entries for audit and review purposes.
 */
class JournalEntryController extends Controller
{
    /**
     * Display all journal entries, ordered by date descending.
     */
    public function index()
    {
        $entries = JournalEntry::with('sale')
                               ->orderBy('date', 'desc')
                               ->orderBy('id', 'asc')
                               ->get();

        return view('journal.index', compact('entries'));
    }
}
