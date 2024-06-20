import ProductItem, {ProductItemData} from 'ShopUi/components/molecules/product-item/product-item';;

// export the extended class
export default class NewProductItem extends ProductItem {

    protected init(): void {
       super.init();
       console.info("your own initial code")
    }
    updateProductItemData(data: ProductItemData): void {
       super.updateProductItemData(data);
       this.productItemName = data.name + 'your own add';
       console.info('additional code maybe')
    }
}
