import {BACKEND_URLS} from "./Links.ts";

const BASE_URL = '/api'

function requester(link:BACKEND_URLS):Promise<Response> {

    return fetch(`${BASE_URL}${link}`, {})
}

export {requester};