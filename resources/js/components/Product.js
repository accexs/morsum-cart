import React from 'react';
import {IconButton, ImageListItem, ImageListItemBar} from '@mui/material';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import AddShoppingCartIcon from '@mui/icons-material/AddShoppingCart';
import {useCart} from '../hooks/useCart';


function Product({item}) {

    const {addProduct, cartItems} = useCart();

    const isInCart = product => {
        return !!cartItems.find(item => item.id === product.id);
    }

    return (
        <ImageListItem>
            <img src={item.image}
                 alt={item.name}
                 loading={'lazy'}
            />
            <ImageListItemBar
                title={item.name}
                subtitle={'$ ' + item.price}
                actionIcon={
                    <IconButton
                        onClick={() => {
                            addProduct(item);
                        }}
                        sx={{color: 'rgba(255, 255, 255, 0.54)'}}
                        aria-label={`info about ${item.name}`}
                    >
                        {
                            isInCart(item) ?
                                <AddShoppingCartIcon/>
                                :
                                <ShoppingCartIcon/>
                        }
                    </IconButton>
                }
            />
        </ImageListItem>
    );
}

export default Product;
