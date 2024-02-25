<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\NotifyProductExpiring;
use App\Jobs\NotifyProductLessStock;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $products = $user->products()
            ->with('lots')
            ->withSum('lots', 'quantity')
            ->paginate(5);

        // return response()->json($products);
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->only('name'));

            $product->lots()->createMany($request->lots);

            return redirect()->route('products.index')->withSuccess('Product created successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return redirect()->back()
                ->withInput($request->all())
                ->withError('Something went wrong.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $product->load('lots');

        return view('pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        try {
            $product->update($request->only('name'));

            /** Get expiry dates from request */
            $expiryDates =  [];
            foreach ($request->lots as $lot) {
                $expiryDates[] = $lot['expiry_date'];
            }

            /** Delete lots that are not in the request by expiry date */
            $product->lots()->whereNotIn('expiry_date', $expiryDates)->delete();

            /** Update or create lots by expiry date */
            foreach ($request->lots as $lot) {
                $product->lots()->updateOrCreate([
                    'expiry_date' => $lot['expiry_date']
                ], $lot);
            }

            return redirect()->route('products.index')->withSuccess('Product updated successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return redirect()->back()
                ->withInput($request->all())
                ->withError('Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        try {
            $product->delete();

            return redirect()->route('products.index')->withSuccess('Product deleted successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return redirect()->back()->withError('Something went wrong.');
        }
    }

    /**
     * Send product expiring mail.
     */
    public function sendExpireMail()
    {
        $user = auth()->user();

        dispatch(new NotifyProductExpiring($user->id));

        return redirect()->back()->withSuccess('Product expiring mail sent successfully.');
    }

    /**
     * Send product less stock mail.
     */
    public function sendLessStockMail()
    {
        $user = auth()->user();

        dispatch(new NotifyProductLessStock($user->id));

        return redirect()->back()->withSuccess('Product less stock mail sent successfully.');
    }
}
