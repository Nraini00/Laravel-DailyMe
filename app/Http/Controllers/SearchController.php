<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparel;  // assuming these models are already created
use App\Models\Budget;
use App\Models\Event;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Search Apparel Table
        $apparels = Apparel::join('type', 'apparel.type_id', '=', 'type.id')
            ->where('apparel.color', 'like', "%{$keyword}%")
            ->orWhere('apparel.brand', 'like', "%{$keyword}%")
            ->orWhere('apparel.name', 'like', "%{$keyword}%")
            ->orWhere('type.type_name', 'like', "%{$keyword}%")
            ->select('apparel.*', 'type.type_name')
            ->get();

        // Search Budget Table
            $budgets = Budget::join('category', 'budget.category_id', '=', 'category.id')
            ->where('budget.title', 'like', "%{$keyword}%")
            ->select('budget.title', 'budget.*', 'category.name as category_name')  // Selecting title explicitly
            ->get();


        // Search Events Table
        $events = Event::where('eventname', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->get();

        // Redirect to respective pages
        if ($apparels->isNotEmpty()) {
            return view('main.apparel_results', compact('apparels'));
        } elseif ($budgets->isNotEmpty()) {
            return view('main.budget_results', compact('budgets'));
        } elseif ($events->isNotEmpty()) {
            return view('main.event_results', compact('events'));
        } else {
            return redirect()->back()->with('message', 'No results found for your search.');
        }
    }
    
}
