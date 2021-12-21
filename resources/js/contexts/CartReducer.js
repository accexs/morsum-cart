const Storage = (state) => {
    localStorage.setItem('cart', JSON.stringify(state));
}

export const CartReducer = (state, action) => {
    console.log('ACTION', action);
    switch (action.type) {
        case "ADD_ITEM":
        case "DECREASE":
            state.cartItems = action.response.data.content;
            state.checkout = false;
            state.total = action.response.data.subtotal;
            state.itemCount = action.response.data.count;
            Storage(state);
            return {...state}
        case "CHECKOUT":
            state = {
                cartItems: [],
                total: 0,
                itemCount: 0,
                checkout: true,
            };
            Storage(state);
            return {...state};
        case "CLEAR":
            state = {
                cartItems: [],
                total: 0,
                itemCount: 0
            };
            Storage(state);
            return {...state};
        default:
            return state

    }
}
