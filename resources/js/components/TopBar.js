import * as React from 'react';
import {Link} from 'react-router-dom';
import {AppBar, Button, Toolbar} from '@mui/material';
import ShoppingCartCheckoutIcon from '@mui/icons-material/ShoppingCartCheckout';
import {useCart} from '../hooks/useCart';

export default function TopBar() {

    const {itemCount} = useCart();

    return (
        <AppBar position={'sticky'} sx={{paddingX: 5}}>
            <Toolbar disableGutters>
                <Button color={'inherit'} component={Link} to={'/'}>Home</Button>
                <Button
                    sx={{marginLeft: 'auto'}}
                    color={'inherit'} component={Link} to={'/cart'}
                >
                    Go to cart <ShoppingCartCheckoutIcon/> ({itemCount})
                </Button>
            </Toolbar>
        </AppBar>
    );
}
