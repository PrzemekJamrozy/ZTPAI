import {useDispatch, useSelector} from "react-redux";
import {RootState} from "../store/store.ts";
import {useEffect, useState} from "react";
import {UserStatusEnum} from "../common/enums/UserStatusEnum.ts";
import {useNavigate} from "react-router";
import onboardingStyles from "../styles/Onboading.module.css"
import commonOnboardingStyles from "../styles/CommonOnboarding.module.css"
import {useForm} from "react-hook-form";
import {OnboardingForm} from "../common/Forms/OnboardingForm.ts";
import {PreferredGenderEnum} from "../common/enums/PreferredGenderEnum.ts";
import {useToast} from "../hooks/useToast.tsx";
import {useImageEncoder} from "../hooks/useImageEncoder.ts";
import {OnboardingPayload} from "../common/Payload/OnboardingPayload.ts";
import {action_finish_onboarding} from "../common/actions/actions.ts";
import {setUser} from "../store/userSlice.ts";


function OnboardingPage() {
    const [onboardingStep, setOnboardingStep] = useState(1);
    const {status} = useSelector((state: RootState) => state.user)
    const navigate = useNavigate();
    const toast = useToast()
    const imageEncoder = useImageEncoder()
    const dispatch = useDispatch()
    const {register, handleSubmit, getValues} = useForm<OnboardingForm>({
        defaultValues: {
            fbLink: "",
            avatar: [],
            bio: "",
            igLink: "",
            preferredGender: PreferredGenderEnum.MALE,
        }
    })

    useEffect(() => {
        if (status === UserStatusEnum.ACTIVE) {
            navigate('/')
            return
        }

        document.body.classList.add(commonOnboardingStyles.commonOnboardingBody)
        return () => {
            document.body.classList.remove(commonOnboardingStyles.commonOnboardingBody)
        }
    })

    const verifyImageStep = () => {
        const value = getValues("avatar")
        return value.length > 0
    }

    const verifyInputStep = (formField: "igLink" | "fbLink" | "bio"): boolean => {
        return getValues(formField).length !== 0
    }

    const verifyStepCompleted = (onboardingStep: number): boolean => {
        switch (onboardingStep) {
            case 1:
                return verifyImageStep();
            case 2:
                return verifyInputStep("bio");
            case 3:
                return verifyInputStep("fbLink");
            case 4:
                return verifyInputStep("igLink");
            default:
                return false;
        }
    }

    const nextStep = () => {
        if (!verifyStepCompleted(onboardingStep)) {
            toast("Prosimy wypełnić dane", "warning")
            return
        }
        setOnboardingStep(onboardingStep + 1)
    }

    const prevStep = () => {
        setOnboardingStep(onboardingStep - 1)
    }

    const _handleSubmit = async (data: OnboardingForm) => {
        toast("Trwa zapisywanie danych", "info")
        let avatar: string = ""
        if (data.avatar?.[0]) {
            avatar = await imageEncoder(data.avatar?.[0])
        }

        //@ts-ignore
        const payload: OnboardingPayload = {...data}
        payload.avatar = avatar

        const result = await action_finish_onboarding(payload)

        if (result.success) {
            dispatch(setUser(result.data))
            navigate('/')
        } else {
            toast("Nie udało się zapisać danych użytkownika", "error")
        }
    }


    return (
        <>
            <div className={`${onboardingStyles.container} ${commonOnboardingStyles.container}`}>
                <form className="onboarding-form" onSubmit={handleSubmit((data) => _handleSubmit(data))}>
                    {onboardingStep === 1 &&
                        <div className="onboarding-step-one">
                            <h2>Wrzuć swoje zdjęcie</h2>
                            <input className="onboarding-input-img" type="file" {...register("avatar")}
                                   accept="image/*" required/>
                        </div>
                    }
                    {
                        onboardingStep === 2 &&
                        <div className="onboarding-step-two">
                            <h2>Opowiedz coś o sobie</h2>
                            <textarea className={onboardingStyles.onboardingTextarea}
                                      required {...register("bio")}></textarea>
                        </div>
                    }
                    {
                        onboardingStep === 3 &&
                        <div className="onboarding-step-three">
                            <h2>Zarzuć link do Facebooka</h2>
                            <div className={commonOnboardingStyles.formGroup}>
                                <input type="text" {...register("fbLink")} className="onboarding-fb-link"
                                       placeholder="Link" required/>
                            </div>
                        </div>
                    }
                    {
                        onboardingStep === 4 &&
                        <div className="onboarding-step-four">
                            <h2>Zarzuć link do Instagrama</h2>
                            <div className={commonOnboardingStyles.formGroup}>
                                <input type="text" {...register("igLink")} className="onboarding-ig-link"
                                       placeholder="Link" required/>
                            </div>
                        </div>
                    }
                    {
                        onboardingStep === 5 &&
                        <div className="onboarding-step-five">
                            <h2>Wolisz być dobierany do?</h2>
                            <div className={commonOnboardingStyles.formGroup}>
                                <select {...register("preferredGender")} className="onboarding-sex" required>
                                    <option value={PreferredGenderEnum.MALE}>Mężczyzna</option>
                                    <option value={PreferredGenderEnum.FEMALE}>Kobieta</option>
                                    <option value={PreferredGenderEnum.BOTH}>Obojętne</option>
                                </select>
                            </div>
                        </div>
                    }
                    <div className={onboardingStyles.onboardingBtnGroup}>
                        {onboardingStep !== 1 &&
                            <button className={onboardingStyles.btnBack} onClick={prevStep}>Wróć</button>}
                        {onboardingStep !== 5 &&
                            <button className={commonOnboardingStyles.btnSubmit} onClick={nextStep}>Następny
                                krok</button>}
                        {onboardingStep === 5 && <button className={commonOnboardingStyles.btnSubmit}>Zakończ</button>}
                    </div>
                </form>
            </div>
        </>
    )
}

export {OnboardingPage}