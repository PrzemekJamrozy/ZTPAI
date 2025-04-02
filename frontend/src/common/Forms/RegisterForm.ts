import {GenderEnum} from "../enums/GenderEnum.ts";

interface RegisterForm {
    email: string;
    password: string;
    passwordAgain: string;
    name:string;
    surname:string;
    gender: GenderEnum;
}

export type {RegisterForm};