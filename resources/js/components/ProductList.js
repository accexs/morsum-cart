import React from 'react';
import {Container, ImageList, Stack} from '@mui/material';
import Product from '../components/Product';
import ProductCart from './ProductCart';

function ProductList({products, cartMode = false}) {
    return (
        <Container>
            {
                cartMode ?
                    <Stack spacing={1}>
                        {products.map(item => (
                            <ProductCart item={item} key={item.id}/>
                        ))}
                    </Stack> :
                    <ImageList cols={4} sx={{minWidth: 200}}>
                        {products.map(item => (
                            <Product item={item} key={item.id}/>
                        ))}
                    </ImageList>
            }
        </Container>
    );
}

export default ProductList;
