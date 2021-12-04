<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCatalogRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех товаров
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $products = Product::orderBy('id', 'DESC')->paginate(15);
        return view('admin.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает товары категории
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category) {
        $products = $category->products()->paginate(5);
        return view('admin.product.category', compact('category', 'products'));
    }

    /**
     * Показывает форму для создания товара
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        return view('admin.product.create', compact('items', 'brands'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCatalogRequest $request) {
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();

        $product = Product::create($data);

        if ( isset($data['image']) ) {
            foreach ( $data['image'] as $image ){
                $name = $this->imageSaver->upload($image, null, 'product/' . $product->id, true);

                $image = new Image();
                $image->name = $name;
                $image->main_image = 0;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает страницу товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'items', 'brands'));
    }

    /**
     * Обновляет товар каталога в базе данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCatalogRequest $request, Product $product) {
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);

        $data = $request->all();

        if ( isset($data['remove']) ) {
            foreach ($data['remove'] as $idImage) {
                $image = Image::find($idImage);
                Storage::disk('public')->delete('catalog/product/' . $product->id . '/image/' . $image->first()->name );
                Storage::disk('public')->delete('catalog/product/' . $product->id . '/source/' . $image->first()->name );
                Storage::disk('public')->delete('catalog/product/' . $product->id . '/thumb/' . $image->first()->name );
                $image->delete();
            }
        }

        if ( isset($data['image']) ) {
            foreach ( $data['image'] as $image ){
                $name = $this->imageSaver->upload($image, null, 'product/' . $product->id, true);
                $image = new Image();
                $image->name = $name;
                $image->main_image = 0;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        $data['brand_id'] = $data['brand_id'] == 0 ? null : $data['brand_id'];

        $product->update($data);
        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Товар был успешно обновлен');
    }

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        Storage::disk('public')->deleteDirectory('catalog/product/' . $product->id );
        $product->delete();
        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Товар успешно удален');
    }
}
