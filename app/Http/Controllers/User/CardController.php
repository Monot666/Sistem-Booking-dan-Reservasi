<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

/**
 * Manages the user's saved bank cards.
 */
class CardController extends Controller
{
    /**
     * Display the user's saved cards.
     */
    public function index()
    {
        $cards = Card::where('user_id', auth()->id())->get();

        return view('profile.cards', compact('cards'));
    }

    /**
     * Store a new card for the user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:30',
            'card_name'      => 'required|string|max:100',
        ]);

        Card::create([
            'user_id'        => auth()->id(),
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'card_name'      => $request->card_name,
        ]);

        return back()->with('success', 'Card added successfully.');
    }

    /**
     * Update an existing card.
     */
    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        abort_if($card->user_id !== auth()->id(), 403);

        $request->validate([
            'bank_name'      => 'sometimes|required|string|max:100',
            'account_number' => 'sometimes|required|string|max:30',
            'card_name'      => 'sometimes|required|string|max:100',
        ]);

        $card->update($request->only(['bank_name', 'account_number', 'card_name']));

        return back()->with('success', 'Card updated successfully.');
    }

    /**
     * Delete a card.
     */
    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        abort_if($card->user_id !== auth()->id(), 403);

        $card->delete();

        return back()->with('success', 'Card deleted successfully.');
    }
}
