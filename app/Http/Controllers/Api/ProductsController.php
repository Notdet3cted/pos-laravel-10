<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ProductsController extends Controller
{
    // use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $products = DB::select("
            SELECT
                p.id,
                p.product_name,
                p.product_image,
                v.level,
                CAST( 
                    CONCAT(
                        '[',
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                'type', v.type,
                                'price', v.price
                                )
                            ),
                        ']'
                    ) AS JSON 
                ) AS variant
            FROM 
                product_variants AS v 
                INNER JOIN products AS p ON v.product_id = p.id
                GROUP BY p.id, v.level
        ");
        dd($products);
        // $products = Products::get();
        return response([
            'success' => true,
            'message' => 'Product Lists',
            'data' => $products
        ], 200);
    }

    public function variants()
    {
        $productVariants = ProductVariants::get();
        return response([
            'success' => true,
            'message' => 'Product Variant Lists',
            'data' => $productVariants
        ], 200);
    }

    // Membuat method di dalam controller
    public function getProducts($level)
    {
        // Mengambil semua data
        $products = DB::select("
            SELECT
                p.id,
                p.product_name,
                p.product_image,
                v.level,
                CAST( 
                    CONCAT(
                        '[',
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                'type', v.type,
                                'price', v.price
                                )
                            ),
                        ']'
                    ) AS JSON 
                ) AS variant
            FROM 
                product_variants AS v 
                INNER JOIN products AS p ON v.product_id = p.id
                WHERE v.level = '" . $level . "'
                GROUP BY p.id, v.level
        ");

        // Jika produk tidak ditemukan, kirim respons dengan kode status 404
        if (!$products) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response([
            'success' => true,
            'message' => 'Product Lists',
            'products' => $products
        ], 200);
    }
}
