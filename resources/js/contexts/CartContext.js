import React, {createContext, useReducer} from 'react';
import {CartReducer} from './CartReducer';

export const CartContext = createContext(undefined)

const storage = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {cartItems: []};
const initialState = {...storage, checkout: false};

const CartContextProvider = ({children}) => {

    const [state, dispatch] = useReducer(CartReducer, initialState);

    const decrease = async payload => {
        console.log(payload);
        const response = await axios.patch('http://morsum.test/api/cart/removeItem', {
            rowId: payload.rowId
        });
        if (response.status === 200) {
            dispatch({type: 'DECREASE', response});
        }
    }

    const addProduct = async payload => {
        console.log(payload);
        const response = await axios.patch('http://morsum.test/api/cart/addItem', {
            id: payload.id
        });
        if (response.status === 200) {
            dispatch({type: 'ADD_ITEM', response});
        }
    }

    const clearCart = async () => {
        const response = await axios.delete('http://morsum.test/api/cart');
        if (response.status === 200) {
            dispatch({type: 'CLEAR'});
        }
    }

    const handleCheckout = async () => {
        console.log('CHECKOUT', state);
        const response = await axios.post('http://morsum.test/api/orders');
        if (response.status === 201) {
            dispatch({type: 'CHECKOUT'});
        }
    }

    const contextValues = {
        addProduct,
        decrease,
        clearCart,
        handleCheckout,
        ...state
    };

    return (
        <CartContext.Provider value={contextValues}>
            {children}
        </CartContext.Provider>
    );
}

export default CartContextProvider;
