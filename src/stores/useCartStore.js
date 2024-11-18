import { defineStore } from "pinia";
import { toast } from 'vue3-toastify';

export const useCartStore = defineStore('cart', {
    state: () => {
        const storedCart = localStorage.getItem('cart');
        return {
            cart: storedCart ? JSON.parse(storedCart) : []
        };
    },

    actions: {
        addToCart(product) {
            this.initCart();
            const productIdentifier = product?.selectSku.sku + (product?.selectSku?.varient || '')  ;
            const index = this.cart.findIndex(item => {
                const itemIdentifier = item?.selectSku.sku + (item?.selectSku?.varient || '');
                return itemIdentifier === productIdentifier;
            });

            if (index > -1) {
                this.cart[index].selectSku.selectQty = product?.selectSku?.selectQty;
            } else {
                this.cart.push(product);
            }

            this.setInLocalStorage();
            toast.success("Added To Cart...", {autoClose:500});
        },
        removeFromCart(item) {
            const index = this.cart.indexOf(item);
            if (index > -1) {
                this.cart.splice(index, 1);
                this.setInLocalStorage();
            }
            toast.success("Removed From Cart...", {autoClose:500});
        },
        incrementQty(id) {
            const index = this.cart.findIndex(item => {
                return item?.selectSku.id === id;
            });
            this.cart[index].selectSku.selectQty++;
            this.setInLocalStorage();
            toast.info("Quantity Updated...", {autoClose:500});
        },
        decrementQty(id) {
            const index = this.cart.findIndex(item => {
                return item?.selectSku.id === id;
            });

            if (this.cart[index].selectSku.selectQty > 1) {
                this.cart[index].selectSku.selectQty--;
            }
            this.setInLocalStorage();
            toast.info("Quantity Updated...", {autoClose:500});
        },
        setInLocalStorage() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
        initCart() {
            const storedCart = localStorage.getItem('cart');
            if (storedCart) {
                this.cart = JSON.parse(storedCart);
            }
        },
        clearCart() {
            this.cart = [];
            localStorage.removeItem("cart");
            this.initCart();
        }
    },

    getters: {
        getCartLength() {
            return this.cart.length;
        },
        getCartItems() {
            return this.cart;
        },
        getCartTotalPrice() {
            return this.cart.reduce((total, item) => total + item.selectSku?.price * ( item?.attachments ? item?.attachments?.length : item?.selectSku?.selectQty), 0);
        }
    }
});