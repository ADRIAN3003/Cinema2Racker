import React from 'react';
import { createRoot } from 'react-dom/client';
import axios from 'axios';
import MoziCrud from './components/MoziCrud';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const rootElement = document.getElementById('react-root');
if (rootElement) {
    createRoot(rootElement).render(
        <React.StrictMode>
            <MoziCrud />
        </React.StrictMode>
    );
}
