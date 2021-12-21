import React from 'react';
import {Container, ImageList, Pagination, Stack} from '@mui/material';
import Product from '../components/Product';
import ProductCart from './ProductCart';
import {useProducts} from "../hooks/useProducts";

function ProductList({products, cartMode = false}) {

    const {productState, fetchProducts} = useProducts();

    const handlePagination = (event, page) => {
        fetchProducts(page);
    }

    return (
        <Container>
            {
                cartMode ?
                    <Stack spacing={1}>
                        {products.map(item => (
                            <ProductCart item={item} key={item.id}/>
                        ))}
                    </Stack> :
                    <Stack spacing={2}>
                        <ImageList cols={4} sx={{minWidth: 200}}>
                            {productState.products.map(item => (
                                <Product item={item} key={item.id}/>
                            ))}
                        </ImageList>
                        <Pagination
                            count={productState.meta.last_page}
                            onChange={handlePagination}
                        />
                    </Stack>

            }
        </Container>
    );
}

export default ProductList;
