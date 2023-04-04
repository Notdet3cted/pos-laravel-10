// async function loadDatabase() {
//   const db = await idb.openDB("tailwind_store", 1, {
//     upgrade(db, oldVersion, newVersion, transaction) {
//       db.createObjectStore("products", {
//         keyPath: "id",
//         autoIncrement: true,
//       });
//       db.createObjectStore("sales", {
//         keyPath: "id",
//         autoIncrement: true,
//       });
//     },
//   });

//   return {
//     db,
//     getProducts: async () => await db.getAll("products"),
//     addProduct: async (product) => await db.add("products", product),
//     editProduct: async (product) =>
//       await db.put("products", product.id, product),
//     deleteProduct: async (product) => await db.delete("products", product.id),
//   };
// }

function initApp() {
  const app = {
    db: null,
    time: null,
    // firstTime: false,
    activeMenu: 'pos',
    loadingSampleData: true,
    moneys: [500, 1000, 5000, 10000, 20000, 50000, 100000],
    products: [],
    keyword: "",
    cart: [],
    cash: 0,
    change: 0,
    isShowModalReceipt: false,
    isShowModalVariant: false,
    receiptNo: null,
    receiptDate: null,
    productFromMenu:null,
    productVariants: [],
    tempProducts: [],
    

    async initDatabase() {
      // this.db = await loadDatabase();
      // this.loadProducts();
      this.startWithSampleData();
    },
    // async loadProducts() {
    //   this.products = await this.db.getProducts();
    //   console.log("products loaded", this.products);
    // },
    
    async startWithSampleData() {
      const {
        host, hostname, href, origin, pathname, port, protocol, search
      } = window.location
      const params = new URLSearchParams(search)
      const comments = params.get('q')
      var level = '';

      if(comments == '0'){
        level = 'ecer'
      }else{
        level = 'b' + comments
      }

      // console.log(comments);
      // const response = await fetch("data/sample.json");
      const response = await fetch("http://localhost:8000/api/products/getproducts/"+level);
      const data = await response.json();
      // console.log(data.data);
      this.products = data.products;
      // for (let product of data.products) {
      //   await this.db.addProduct(product);
      //   // console.log(product)
      // }

      // this.setFirstTime(false);
    },
    
    filteredProducts() {
      const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
      return this.products.filter((p) => !rg || p.name.match(rg));
    },

    addToCart(product, price, type) {
      const index = this.findCartIndex(product);
      if (index === -1) {
        this.cart.push({
          productId: product.id,
          product_image: product.product_image,
          product_name: product.product_name,
          // price: product.price,
          price: price,
          subTotal: 0,
          // option: product.option,
          qty: 1,
        });
      } else {
        this.cart[index].qty += 1;
      }
      // console.log(this.cart)
      this.closeModalVariant();
      this.beep();
      this.updateChange();
    },
    findCartIndex(product) {
      return this.cart.findIndex((p) => p.productId === product.id);
    },

    addQty(item, qty) {
      const index = this.cart.findIndex((i) => i.productId === item.productId);
      if (index === -1) {
        return;
      }

      const afterAdd = item.qty + qty;
      if (afterAdd === 0) {
        this.cart.splice(index, 1);
        this.clearSound();
      } else {
        this.cart[index].qty = afterAdd;
        this.beep();
      }
      this.updateChange();
    },
    addCash(amount) {      
      this.cash = (this.cash || 0) + amount;
      this.updateChange();
      this.beep();
    },
    getItemsCount() {
      return this.cart.reduce((count, item) => count + item.qty, 0);
    },
    updateChange() {
      this.change = this.cash - this.getTotalPrice();
    },
    updateCash(value) {
      this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      this.updateChange();
    },

    getTotalPrice() {
      return this.cart.reduce(
        function(total, item) {
          let perkalian
          perkalian = item.qty * item.price
          if(item.name == 'marimas'){
              if(item.qty % 2 == 0){
                perkalian = ((item.qty) * 3250)
              }else if(item.qty > 2 && item.qty % 2 != 0){
                perkalian = ((item.qty - 1) * 3250) + 3500
              }
          }
          item.subTotal = perkalian
          return total + perkalian;
        }, 0
      );
    },
    submitable() {
      return this.change >= 0 && this.cart.length > 0;
    },

    submit() {
      const time = new Date();
      this.isShowModalReceipt = true;
      this.receiptNo = `TWPOS-KS-${Math.round(time.getTime() / 1000)}`;
      this.receiptDate = this.dateFormat(time);
    },

    chooseVariant(product) {
      this.tempProducts = product
      let getVariants = JSON.parse(JSON.stringify(product.variant))
      this.productVariants = JSON.parse(getVariants);
      // for (let i = 0; i < getVariants.length; i++) {
      //   if(getVariants[i].name != 'reguler'){
      //     continue;
      //   }
        
        // this.productVariants = (getVariants[i].options);
        
      // }
      this.isShowModalVariant = true;
      
    },

    closeModalReceipt() {
      this.clearSound();
      this.clear();
      this.isShowModalReceipt = false;
    },
    closeModalVariant() {
      this.isShowModalVariant = false;
    },
    dateFormat(date) {
      const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short'});
      return formatter.format(date);
    },
    numberFormat(number) {
      return (number || "")
        .toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },
    priceFormat(number) {
      return number ? `Rp. ${this.numberFormat(number)}` : `Rp. 0`;
    },
    clear() {
      this.cash = 0;
      this.cart = [];
      this.receiptNo = null;
      this.receiptDate = null;
      this.updateChange();
      this.clearSound();
    },
    beep() {
      this.playSound("http://localhost:8000/front/sound/beep-29.mp3");
    },
    
    clearSound() {
      this.playSound("http://localhost:8000/front/sound/button-21.mp3");
    },

    playSound(src) {
      const sound = new Audio();
      sound.src = src;
      sound.play();
      sound.onended = () => delete(sound);
    },

    printAndProceed() {
      const receiptContent = document.getElementById('receipt-content');
      const titleBefore = document.title;
      const printArea = document.getElementById('print-area');

      printArea.innerHTML = receiptContent.innerHTML;
      document.title = this.receiptNo;

      window.print();
      this.isShowModalReceipt = false;

      printArea.innerHTML = '';
      document.title = titleBefore;

      // let getCart = JSON.parse(JSON.stringify(this.cart))
      // console.log(getCart);
      // for (let i = 0; i < getCart.length; i++) {
      //   console.log(getCart[i].price);
      // }
      // TODO save sale data to database

      // return;
      this.clear();
    }
  };

  return app;
}
