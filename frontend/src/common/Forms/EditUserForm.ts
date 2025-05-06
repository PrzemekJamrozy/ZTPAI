import {PreferredGenderEnum} from "../enums/PreferredGenderEnum.ts";
import {RolesEnum} from "../enums/RolesEnum.ts";

type EditUserProfile = {
    preferredGender: PreferredGenderEnum
    fbLink: string
    igLink: string
    bio: string
    avatar: File[]
}

type EditUserForm = {
    email: string
    password: string
    profile: EditUserProfile
}

type EditUserPayload = Omit<EditUserForm, 'profile'> & {
    profile: Omit<EditUserProfile, 'avatar'> & {
        avatar: string;
    };
};

type AdminEditUserForm = EditUserForm & {
    role: RolesEnum
}

export type {EditUserForm, AdminEditUserForm, EditUserPayload}