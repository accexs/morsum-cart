import React, {createContext, useEffect, useState} from 'react';

export const ProductsContext = createContext(undefined)

const ProductsContextProvider = ({children}) => {

    const [productState, setProductsData] = useState({
        products: [],
        links: [],
        meta: []
    });

    const fetchProducts = async (pageNumber) => {
        const response = await axios.get('http://morsum.test/api/products?page=' + pageNumber);
        if (response.status === 200) {
            console.log('state response', response);
            setProductsData({
                products: response.data.data,
                links: response.data.links,
                meta: response.data.meta
            });
        }
    }

    useEffect(async () => {
        await fetchProducts();
    }, []);

    const contextValues = {
        fetchProducts,
        productState
    }

    return (
        <ProductsContext.Provider value={contextValues}>
            {children}
        </ProductsContext.Provider>
    );
}

export default ProductsContextProvider;

