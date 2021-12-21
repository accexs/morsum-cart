import React, {createContext, useReducer} from 'react';
import {CartReducer} from './CartReducer';

export const CartContext = createContext(undefined)

const storage = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {cartItems: []};
const initialState = {...storage, checkout: false};

const CartContextProvider = ({children}) => {

    const [state, dispatch] = useReducer(CartReducer, initialState);

    const decrease = async payload => {
        // TODO: handle response error
        const response = await axios.patch('http://morsum.test/api/cart/removeItem', {
            rowId: payload.rowId
        });
        dispatch({type: 'DECREASE', response})
    }

    const addProduct = async payload => {
        // TODO: handle response error
        const response = await axios.patch('http://morsum.test/api/cart/addItem', {
            id: payload.id
        });
        dispatch({type: 'ADD_ITEM', response})
    }

    const clearCart = async () => {
        // TODO: handle response error
        const response = await axios.delete('http://morsum.test/api/cart');
        dispatch({type: 'CLEAR'})
    }

    const handleCheckout = async () => {
        console.log('CHECKOUT', state);
        // TODO: handle response error
        const response = await axios.post('http://morsum.test/api/orders');
        dispatch({type: 'CHECKOUT'})
    }

    const contextValues = {
        addProduct,
        decrease,
        clearCart,
        handleCheckout,
        ...state
    }

    return (
        <CartContext.Provider value={contextValues}>
            {children}
        </CartContext.Provider>
    );
}

export default CartContextProvider;
