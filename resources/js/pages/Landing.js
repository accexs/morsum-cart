import React from 'react';
import {Box, Typography, Divider} from '@mui/material';
import ProductList from '../components/ProductList';
import {useProducts} from '../hooks/useProducts';

function Landing() {

    const {productState} = useProducts();

    return (
        <Box sx={{my: 4}}>
            <Box sx={{mx: 4}}>
                <Typography variant={'h3'} gutterBottom>
                    View cart and checkout
                </Typography>
            </Box>
            <Divider sx={{marginX: 0}} variant={'middle'}/>
            <Box sx={{my: 4}}>
                <ProductList productState={productState}/>
            </Box>
        </Box>
    );
}

export default Landing;
