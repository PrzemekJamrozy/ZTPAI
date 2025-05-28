import {BACKEND_URLS} from "./Links.ts";

const BASE_URL = 'http://localhost:9001/api'

type MethodType = "GET" | "POST" | "PUT" | "PATCH" | "DELETE";

type Payload = {
    headers: Object;
    body?: Object;
    method: MethodType;
}

function requester<T>(link: BACKEND_URLS|string, method: MethodType, payload?: T|Object): Promise<Response> {
    const token = localStorage.getItem("token");
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }

    if(token){
        headers['Authorization'] = `Bearer ${token}` ;
    }
    const body = payload ? JSON.stringify(payload) : null;
    let data:Payload = {method, headers}

    if(body !== null) {
        data = {...data, body: body}
    }

    // @ts-ignore
    return fetch(`${BASE_URL}${link}`, data)

}

export {requester};