import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Routes, Route} from 'react-router-dom';
import TopBar from './TopBar';
import Landing from '../pages/Landing';
import Cart from '../pages/Cart';
import {Container, createTheme, Link, Typography} from '@mui/material';
import {blueGrey, green} from '@mui/material/colors';
import {ThemeProvider} from '@emotion/react';
import CartContextProvider from '../contexts/CartContext';
import ProductsContextProvider from '../contexts/ProductsContext';

const theme = createTheme({
    palette: {
        primary: {
            main: blueGrey[500]
        },
        secondary: {
            main: green[900]
        },
    }
});

function Copyright() {
    return (
        <Typography variant={'body2'} color={'text.secondary'} align={'center'}>
            {'Copyright © '}
            <Link color={'inherit'} href={'#'}>
                Morsum
            </Link>{' '}
            {new Date().getFullYear()}
            {'.'}
        </Typography>
    );
}

function App() {
    return (
        <BrowserRouter>
            <ThemeProvider theme={theme}>
                <Container maxWidth={'lg'}>
                    <ProductsContextProvider>
                        <CartContextProvider>
                            <TopBar/>
                            <Routes>
                                <Route path={'/'} element={<Landing/>}/>
                                <Route path={'/cart'} element={<Cart/>}/>
                            </Routes>
                            <Copyright/>
                        </CartContextProvider>
                    </ProductsContextProvider>
                </Container>
            </ThemeProvider>
        </BrowserRouter>
    );
}


export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}
