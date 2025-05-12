import {PreferredGenderEnum} from "../enums/PreferredGenderEnum.ts";

type OnboardingPayload = {
    bio: string
    fbLink: string
    igLink: string
    preferredGender: PreferredGenderEnum
    avatar: string
}

export type {OnboardingPayload}