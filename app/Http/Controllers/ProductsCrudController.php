<?php

namespace App\Http\Controllers;

//import Model "Post
use App\Models\ProductVariants;
use App\Models\Products;
use Carbon\Carbon;
//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class ProductsCrudController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get posts
        // $posts = Post::latest()->paginate(5);

        //render view with posts
        return view('admin.product.lists');
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.product.add');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $uid = Carbon::now()->format('ymdHis');

        //validate form
        $this->validate($request, [
            'product_image'     => 'required|image|mimes:jpeg,jpg,png|max:2048|dimensions:ratio=1',
            'product_name'      => 'required',
            'product_stock'     => 'required'
        ]);

        //upload image
        $image = $request->file('product_image');
        $image->storeAs('public/products', $image->hashName());
        $width = $image->height() == $image->width();
        //create product 
        Products::create([
            'id'                => $uid,
            'product_name'      => $request->product_name,
            'product_image'     => $image->hashName(),
            'product_stock'     => $request->product_stock
        ]);

        // create variant
        for ($i = 0; $i < sizeof($request->level); $i++) {
            ProductVariants::create([
                'product_id' => $uid,
                'level'     => $request->level[$i],
                'type'      => $request->type[$i],
                'price'     => $request->price[$i]
            ]);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Product berhasil ditambahkan!']);
    }
}
