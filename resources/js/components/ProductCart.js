import React from 'react';
import {ButtonBase, Grid, IconButton, Paper, Typography} from '@mui/material';
import AddShoppingCartIcon from '@mui/icons-material/AddShoppingCart';
import RemoveCircleOutlineIcon from '@mui/icons-material/RemoveCircleOutline';
import {useCart} from '../hooks/useCart';
import styled from '@emotion/styled';

const Img = styled('img')({
    margin: 'auto',
    display: 'block',
    maxWidth: '100%',
    maxHeight: '100%',
});

function Product({item}) {

    const {addProduct, decrease} = useCart();


    return (
        <Paper sx={{p: 2, flexGrow: 1}}>
            <Grid container spacing={2}>
                <Grid item>
                    <ButtonBase sx={{width: 128, height: 128}}>
                        <Img alt={item.name} src={item.image} loading={'lazy'}/>
                    </ButtonBase>
                </Grid>
                <Grid item xs={12} sm container>
                    <Grid item xs container direction={'column'} spacing={2}>
                        <Grid item container xs>
                            <Grid xs={6}>
                                <Typography variant={'subtitle1'} gutterBottom>
                                    {item.name}
                                </Typography>
                                <Typography variant={'body2'} gutterBottom>
                                    quantity: {item.qty}
                                </Typography>
                            </Grid>
                            <Grid xs={6}>
                                <Typography variant={'h5'} gutterBottom align={'right'}>
                                    $ {item.price}
                                </Typography>
                                {
                                    item.qty > 1 &&
                                    <Typography variant={'body2'} gutterBottom align={'right'}>
                                        Subtotal: $ {item.subtotal}
                                    </Typography>
                                }
                            </Grid>
                        </Grid>
                        <Grid item>
                            <IconButton>
                                <AddShoppingCartIcon onClick={() => addProduct(item)} sx={{color: 'green'}}/>
                            </IconButton>
                            <IconButton>
                                <RemoveCircleOutlineIcon onClick={() => decrease(item)} sx={{color: 'red'}}/>
                            </IconButton>
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        </Paper>
    );
}

export default Product;
