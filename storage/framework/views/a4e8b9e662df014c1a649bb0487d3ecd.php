<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tailwind POS</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('front/css/style.css')); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset('front/favicon.ico')); ?>" type="image/x-icon" />
    <!-- <script src="https://unpkg.com/idb/build/iife/index-min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/idb@7/build/umd.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <script src="<?php echo e(asset('front/js/script.js')); ?>"></script>
</head>

<body class="bg-blue-gray-50" x-data="initApp()" x-init="initDatabase()">
    <!-- noprint-area -->
    <div class="hide-print flex flex-row h-screen antialiased text-blue-gray-800">
        <!-- page content -->
        <div class="flex-grow flex">
            <!-- store menu -->
            <div class="flex flex-col bg-blue-gray-50 h-full w-full py-4">
                <!-- categories -->

                <div class="mt-5 flex flex-row px-5 mb-5" x-data="{ bakuls: ['0', '1', '2', '3', '4'], isActive: false }">
                    <a href="<?php echo e(route('products.index')); ?>">
                        <button class="px-5 py-1 bg-cyan-500 rounded-2xl text-white text-sm mr-4">
                            MENU
                        </button>
                    </a>
                    <template x-for="bakul in bakuls" class="">
                        <a x-bind:href="'?q=' + bakul">
                            <button class="px-5 py-1 bg-cyan-500 rounded-2xl text-white text-sm mr-4" x-text="bakul"
                                x-cloak @click="{bakul = new URLSearchParams(location.search).get('q')}"
                                x-bind:class="{
                                    'bg-cyan-500': bakul === new URLSearchParams(location.search).get(
                                        'q'),
                                    'bg-cyan-100': bakul != new URLSearchParams(location.search).get('q')
                                }"></button>
                        </a>
                    </template>
                </div>
                <!-- end Categories -->
                <div class="flex px-2 flex-row relative">
                    <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-cyan-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                        class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
                        placeholder="Cari menu ..." x-model="keyword" />
                </div>
                <div class="h-full overflow-hidden mt-4">
                    <div class="h-full overflow-y-auto px-2">
                        <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                            x-show="products.length === 0">
                            <div class="w-full text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                </svg>
                                <p class="text-xl">
                                    YOU DON'T HAVE
                                    <br />
                                    ANY PRODUCTS TO SHOW
                                </p>
                            </div>
                        </div>
                        <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                            x-show="filteredProducts().length === 0 && keyword.length > 0">
                            <div class="w-full text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-xl">
                                    EMPTY SEARCH RESULT
                                    <br />
                                    "<span x-text="keyword" class="font-semibold"></span>"
                                </p>
                            </div>
                        </div>
                        <div x-show="filteredProducts().length" class="grid grid-cols-4 gap-4 pb-3">
                            <template x-for="product in filteredProducts()" :key="product.id">
                                <div role="button"
                                    class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg"
                                    :title="product.product_name" x-on:click="chooseVariant(product)">
                                    <!-- x-on:click="addToCart(product, new URLSearchParams(location.search).get('q'))" -->
                                    <p class="text-center text-xl font-bold mb-3 mt-3" x-text="product.product_name">
                                    </p>
                                    <img :src="'<?php echo e(Storage::url('products')); ?>/' + product.product_image"
                                        :alt="product.product_name" class="object-contain h-48 w-48" />
                                    <p class="text-center text-xl font-bold mb-3 mt-3"
                                        x-text="
                                    new URLSearchParams(location.search).get(
                                        'q')== 1 ? priceFormat(JSON.parse(product.variant).find(variant => variant.type ===
                                        'pcs')?.price) : priceFormat(JSON.parse(product.variant)[0]?.price)">
                                    </p>
                                    
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of store menu -->

            <!-- right sidebar -->
            <div class="w-5/12 flex flex-col bg-blue-gray-50 h-full bg-white pr-4 pl-2 py-4">
                <div class="bg-white rounded-3xl flex flex-col h-full shadow">
                    <!-- empty cart -->
                    <div x-show="cart.length === 0"
                        class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p>CART EMPTY</p>
                    </div>

                    <!-- cart items -->
                    <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
                        <div class="h-16 text-center flex justify-center">
                            <div class="pl-8 text-left text-lg py-4 relative">
                                <!-- cart icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <div x-show="getItemsCount() > 0"
                                    class="text-center absolute bg-cyan-500 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3"
                                    x-text="getItemsCount()"></div>
                            </div>
                            <div class="flex-grow px-8 text-right text-lg py-4 relative">
                                <!-- trash button -->
                                <button x-on:click="clear()"
                                    class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 w-full px-4 overflow-auto">
                            <template x-for="item in cart" :key="item.productId">
                                <div
                                    class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                                    <img :src="'<?php echo e(Storage::url('products')); ?>/' + item.product_image" alt=""
                                        class="rounded-lg h-10 w-10 bg-white shadow mr-2" />
                                    <div class="flex-grow">
                                        <h5 class="text-sm" x-text="item.product_name"></h5>
                                        <p class="text-xs block" x-text="priceFormat(item.price)"></p>
                                    </div>
                                    <div class="py-1">
                                        <div class="w-28 grid grid-cols-3 gap-2 ml-2">
                                            <button x-on:click="addQty(item, -1)"
                                                class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input x-model.number="item.qty" type="text"
                                                class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm" />
                                            <button x-on:click="addQty(item, 1)"
                                                class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- end of cart items -->

                    <!-- payment info -->
                    <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
                        <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                            <div>TOTAL</div>
                            <div class="text-right w-full" x-text="priceFormat(getTotalPrice())"></div>
                        </div>
                        <div class="mb-3 text-blue-gray-700 px-3 pt-2 pb-3 rounded-lg bg-blue-gray-50">
                            <div class="flex text-lg font-semibold">
                                <div class="flex-grow text-left">CASH</div>
                                <div class="flex text-right">
                                    <div class="mr-2">Rp</div>
                                    <input x-bind:value="numberFormat(cash)"
                                        x-on:keyup="updateCash($event.target.value)" type="text"
                                        class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none" />
                                </div>
                            </div>
                            <hr class="my-2" />
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                <template x-for="money in moneys">
                                    <button x-on:click="addCash(money)"
                                        class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                                        +<span x-text="numberFormat(money)"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div x-show="change > 0"
                            class="flex mb-3 text-lg font-semibold bg-cyan-50 text-blue-gray-700 rounded-lg py-2 px-3">
                            <div class="text-cyan-800">CHANGE</div>
                            <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(change)"></div>
                        </div>
                        <div x-show="change < 0"
                            class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3">
                            <div class="text-right flex-grow text-pink-600" x-text="priceFormat(change)"></div>
                        </div>
                        <div x-show="change == 0 && cart.length > 0"
                            class="flex justify-center mb-3 text-lg font-semibold bg-cyan-50 text-cyan-700 rounded-lg py-2 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                        </div>
                        <button class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none"
                            x-bind:class="{
                                'bg-cyan-500 hover:bg-cyan-600': submitable(),
                                'bg-blue-gray-200': !submitable()
                            }"
                            :disabled="!submitable()" x-on:click="submit()">
                            SUBMIT
                        </button>
                    </div>
                    <!-- end of payment info -->
                </div>
            </div>
            <!-- end of right sidebar -->
        </div>
        <!-- modal receipt -->
        <div x-show="isShowModalReceipt"
            class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
            <div x-show="isShowModalReceipt" class="fixed glass w-full h-screen left-0 top-0 z-0"
                x-on:click="closeModalReceipt()" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>
            <div x-show="isShowModalReceipt" class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
                    <div class="text-center">
                        <img src="<?php echo e(asset('front/img/receipt-logo.png')); ?>" alt="Tailwind POS"
                            class="mb-3 w-8 h-8 inline-block" />
                        <h2 class="text-xl font-semibold">TAILWIND POS</h2>
                        <p>CABANG KONOHA SELATAN</p>
                    </div>
                    <div class="flex mt-4 text-xs">
                        <div class="flex-grow">
                            No: <span x-text="receiptNo"></span>
                        </div>
                        <div x-text="receiptDate"></div>
                    </div>
                    <hr class="my-2" />
                    <div>
                        <table class="w-full text-xs">
                            <thead>
                                <tr>
                                    <th class="py-1 w-1/12 text-center">
                                        #
                                    </th>
                                    <th class="py-1 text-left">Item</th>
                                    <th class="py-1 w-2/12 text-center">
                                        Qty
                                    </th>
                                    <th class="py-1 w-3/12 text-right">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in cart" :key="item">
                                    <tr>
                                        <td class="py-2 text-center" x-text="index+1"></td>
                                        <td class="py-2 text-left">
                                            <span x-text="item.name"></span>
                                            <br />
                                            <small x-text="priceFormat(item.price)"></small>
                                        </td>
                                        <td class="py-2 text-center" x-text="item.qty"></td>
                                        <td class="py-2 text-right" x-text="priceFormat(item.subTotal)"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-2" />
                    <div>
                        <div class="flex font-semibold">
                            <div class="flex-grow">TOTAL</div>
                            <div x-text="priceFormat(getTotalPrice())"></div>
                        </div>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">PAY AMOUNT</div>
                            <div x-text="priceFormat(cash)"></div>
                        </div>
                        <hr class="my-2" />
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">CHANGE</div>
                            <div x-text="priceFormat(change)"></div>
                        </div>
                    </div>
                </div>
                <div class="p-4 w-full">
                    <button class="bg-red-500 mb-4 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none"
                        x-on:click="closeModalReceipt()">
                        CLOSE
                    </button>
                    <button class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none"
                        x-on:click="printAndProceed()">
                        PROCEED
                    </button>
                </div>
            </div>
        </div>

        <!-- modal variant -->
        <div x-show="isShowModalVariant"
            class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
            <div x-show="isShowModalVariant" class="fixed glass w-full h-screen left-0 top-0 z-0"
                x-on:click="closeModalVariant()" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>
            <div x-show="isShowModalVariant" class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div id="receipt-content" class="text-center w-full text-sm p-6 overflow-auto" x-show="tempProducts">
                    <template x-for="variant in productVariants">
                        <div role="button"
                            class="max-w-sm mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                            x-on:click="addToCart(tempProducts, variant.price)">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                x-text="variant.type"></h5>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <!-- end of noprint-area -->

    <div id="print-area" class="print-area"></div>
</body>

</html>
<?php /**PATH D:\project\laravel\pos-laravel-10\resources\views/front/vpos.blade.php ENDPATH**/ ?>