import {BACKEND_URLS} from "./Links.ts";

const BASE_URL = 'http://localhost:9001/api'

type MethodType = "GET" | "POST" | "PUT" | "PATCH" | "DELETE";

function requester<T>(link: BACKEND_URLS, method: MethodType, payload?: T): Promise<Response> {
    const token = localStorage.getItem("token");
    const headers = {
        'Content-Type': 'application/json',
    }

    if(token){
        headers['Authorization'] = `Bearer ${token}` ;
    }

    return fetch(`${BASE_URL}${link}`, {
        method,
        headers,
        body: JSON.stringify(payload),
    })

}

export {requester};