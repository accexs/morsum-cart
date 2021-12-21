import React, {createContext, useEffect, useState} from 'react';

export const ProductsContext = createContext(undefined)

const ProductsContextProvider = ({children}) => {

    const [products, setProductsData] = useState([]);
    useEffect(async () => {
        // TODO: handle response error
        const response = await axios.get('http://morsum.test/api/products');
        setProductsData(response.data);
    }, []);
    return (
        <ProductsContext.Provider value={{products}}>
            {children}
        </ProductsContext.Provider>
    );
}

export default ProductsContextProvider;

