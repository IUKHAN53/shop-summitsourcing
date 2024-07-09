<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Display all wishlist items for the authenticated user
    public function index()
    {
        $userId = Auth::id();
        $wishlistItems = Wishlist::where('user_id', $userId)->get();
        $alibaba = new \App\Services\AlibabaService();
        $wishlist = [];
        foreach ($wishlistItems as $item) {
            $params = [
                'offerDetailParam' => json_encode([
                    'offerId' => $item->product_id,
                    'country' => 'en'
                ]),
            ];
            $product_detail = $alibaba->getProductDetails($params);

            $product = [
                'id' => $item->id,
                'item_id' => $item->product_id,
                'title' => $product_detail['result']['result']['subjectTrans'],
                'images' => $product_detail['result']['result']['productImage']['images'],
                'quantity' => $product_detail['result']['result']['productSaleInfo']['amountOnSale'],
                'sold' => $product_detail['result']['result']['soldOut'],
                'price' => $product_detail['result']['result']['productSaleInfo']['priceRangeList'][0]['price'],
                'rating' => $product_detail['result']['result']['tradeScore'],
                'width' => calculateWidth($product_detail['result']['result']['tradeScore']),
            ];
            $wishlist[] = $product;
        }
        return view('frontend.wishlist', compact('wishlist'));
    }


    public function removeItem($id)
    {
        $wishlistItem = Wishlist::find($id);
        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Item removed from wishlist');
        }
        return back()->with('error', 'Item not found in wishlist');
    }

    // Clear all items from the wishlist
    public function clear()
    {
        $userId = Auth::id();
        Wishlist::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Wishlist cleared'], 200);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');

        $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'action' => 'removed',
                'wishlist_count' => Wishlist::where('user_id', $userId)->count()
            ]);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return response()->json([
                'action' => 'added',
                'wishlist_count' => Wishlist::where('user_id', $userId)->count()
            ]);
        }
    }

}
