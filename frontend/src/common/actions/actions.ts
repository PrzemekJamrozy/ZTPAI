import {RegisterForm} from "../Forms/RegisterForm.ts";

const action_register = (data:RegisterForm) => {

    fetch('http://localhost:9001/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
    })
        .then((res) => res.json())
        .then((res) => {
            console.log(res);
        })
}

const action_get_users = (callback) => {
    return fetch('http://localhost:9001/api/admin/user/temp', {
        method: 'GET',
    })
        .then((res) => res.json())
        .then((res) => callback(res.data))
}

const action_get_user = (userId,callback) => {
    return fetch('http://localhost:9001/api/admin/user/temp/' + userId, {
        method: 'GET',
    })
        .then((res) => res.json())
        .then((res) => callback(res.data))
}

export {
    action_register,
    action_get_users,
    action_get_user
}