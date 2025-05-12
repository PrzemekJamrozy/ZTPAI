import {PreferredGenderEnum} from "../enums/PreferredGenderEnum.ts";

type OnboardingForm = {
    bio: string
    fbLink: string
    igLink: string
    preferredGender: PreferredGenderEnum
    avatar: File[]
}

export type {OnboardingForm}