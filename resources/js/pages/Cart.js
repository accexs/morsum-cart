import React from 'react';
import {Box, Typography, Divider, Button, Grid, Paper, Alert, Stack} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import ShoppingCartCheckoutIcon from '@mui/icons-material/ShoppingCartCheckout';
import {useCart} from '../hooks/useCart';
import ProductList from '../components/ProductList';

function Landing() {

    const {total, cartItems, itemCount, clearCart, checkout, handleCheckout} = useCart();

    return (
        <Box sx={{my: 4}}>
            <Box sx={{mx: 4}}>
                <Typography variant={'h3'} gutterBottom>
                    View cart and checkout
                </Typography>
            </Box>
            <Divider sx={{marginX: 0}} variant={'middle'}/>
            <Box sx={{my: 4}}>
                <Grid container spacing={2}>
                    {
                        (cartItems.length < 1 && !checkout) &&
                        <Grid item xs={12}>
                            <Alert severity={'info'}>
                                Your cart is empty!
                            </Alert>
                        </Grid>
                    }
                    {
                        checkout &&
                        <Grid item xs={12}>
                            <Alert severity={'success'}>
                                Your order was placed!! Check your email for details.
                            </Alert>
                        </Grid>
                    }
                    <Grid item xs={8}>
                        {
                            cartItems.length > 0 &&
                            <ProductList products={cartItems} cartMode={true}/>
                        }
                    </Grid>
                    {
                        cartItems.length > 0 &&
                        <Grid item xs={4}>
                            <Paper sx={{p: 2}} elevation={3}>
                                <Stack spacing={1}>
                                    <Typography variant={'body2'}># Items: {itemCount}</Typography>
                                    <Typography variant={'subtitle1'}>Total: $ {total}</Typography>
                                    <Stack direction={'row'} spacing={1} justifyContent={'center'}>
                                        <Button
                                            variant={'outlined'}
                                            color={'error'}
                                            startIcon={<DeleteIcon/>}
                                            onClick={clearCart}
                                        >
                                            CLEAR
                                        </Button>
                                        <Button
                                            variant={'outlined'}
                                            color={'success'}
                                            startIcon={<ShoppingCartCheckoutIcon/>}
                                            onClick={handleCheckout}
                                        >
                                            CHECKOUT
                                        </Button>
                                    </Stack>
                                </Stack>

                            </Paper>
                        </Grid>
                    }
                </Grid>
            </Box>
        </Box>
    );
}

export default Landing;
