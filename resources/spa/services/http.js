import axios from 'axios'

import { fixUrl } from '../utils';

export async function get(url) {
    try {
        const res = await axios.get(fixUrl(url));
        return res.data;
    }
    catch (err) {
        handleHttpError(err);
        return null;
    }
}

export async function post(url, data) {
    try {
        const res = await axios.post(fixUrl(url), data);
        return res.data;
    }
    catch (err) {
        handleHttpError(err);
        return null;
    }
}

export async function patch(url, data) {
    try {
        const res = await axios.patch(fixUrl(url), data);
        return res.data;
    }
    catch (err) {
        handleHttpError(err);
        return null;
    }
}

export async function remove(url, resource) {
    try {
        const res = await axios.delete(fixUrl(url));
        return res.data;
    }
    catch (err) {
        handleHttpError(err);
        return null;
    }
}

function handleHttpError(err) {
    // handle errors here globally
    console.log(err);
    window.httpError = err
}
