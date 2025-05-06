import styles from "../../styles/UserEdit.module.css"
import {useEffect, useState} from "react";
import {useForm} from "react-hook-form";
import {AdminEditUserForm, EditUserPayload} from "../../common/Forms/EditUserForm.ts";
import {GenderEnum} from "../../common/enums/GenderEnum.ts";
import {LoggedContainer} from "../LoggedContainer.tsx";
import {PreferredGenderEnum} from "../../common/enums/PreferredGenderEnum.ts";
import {useParams} from "react-router";
import {useToast} from "../../hooks/useToast.tsx";
import {action_admin_get_user, action_admin_update_user} from "../../common/actions/actions.ts";
import {Spinner} from "../../components/Spinner.tsx";
import {RolesEnum} from "../../common/enums/RolesEnum.ts";
import {useImageEncoder} from "../../hooks/useImageEncoder.ts";

function AdminUserEdit() {
    const {userId} = useParams();
    const [loading, setLoading] = useState(true);
    const toast = useToast();
    const imageEncoder = useImageEncoder()
    const {register, handleSubmit, setValue} = useForm<AdminEditUserForm>({
        defaultValues: {
            profile: {
                fbLink: "",
                igLink: "",
                bio: "",
                preferredGender: PreferredGenderEnum.MALE,
                avatar: []
            },
            email: "",
            password: "",
            role: RolesEnum.USER
        }
    });

    useEffect(() => {
        const _getUser = async () => {
            if (userId === null || isNaN(parseInt(userId))) {
                toast("Nie można pobrać danych użytkownika", "error")
                setLoading(false)
                return
            }

            const result = await action_admin_get_user(parseInt(userId))

            if (result.success) {
                setValue("profile.fbLink", result.data.profile.fbLink)
                setValue("profile.igLink", result.data.profile.igLink)
                setValue("profile.bio", result.data.profile.bio)
                setValue("profile.preferredGender", result.data.profile.preferredGender)
                setValue("email", result.data.email)
                setValue("role", result.data.roles[0])
            } else {
                toast("Nie udało się pobrać danych użytkownika", "error")
            }
            setLoading(false)
        }

        _getUser()

        document.body.classList.add(styles.userEditBody);
        return () => {
            document.body.classList.remove(styles.userEditBody);
        };
    }, []);

    const _handleSubmit = async (data: AdminEditUserForm) => {
        let avatar: string = ""
        if(data.profile.avatar?.[0]){
            avatar = await imageEncoder(data.profile.avatar?.[0])
        }

        //@ts-ignore
        const payload: EditUserPayload = {...data}
        payload.profile.avatar = avatar
        const result = await action_admin_update_user(parseInt(userId), payload)

        if(result.success) {
            toast("Zaktualizowano użytkownika")

        }else {
            toast("Wystąpił błąd w trakcie aktualizacji użytkownika", "error")
        }
    }


    return (
        <LoggedContainer>
            {loading && <Spinner/>}
            {!loading && <>
                <div className={styles.container} id="edit-user">
                    <h1>Edytuj Użytkownika</h1>
                    <form onSubmit={handleSubmit((data)=> _handleSubmit(data))}>
                        <label>Link do Facebooka: <input type="url" {...register("profile.fbLink")}/></label><br/>
                        <label>Link do Instagrama: <input type="url" {...register("profile.igLink")}/></label><br/>
                        <label>Bio: <textarea {...register("profile.bio")}></textarea></label><br/>
                        <label>Preferowana płeć:
                            <select {...register("profile.preferredGender")}>
                                <option value={PreferredGenderEnum.MALE}>Mężczyzna</option>
                                <option value={PreferredGenderEnum.FEMALE}>Kobieta</option>
                                <option value={PreferredGenderEnum.BOTH}>Obie</option>
                            </select>
                        </label><br/>
                        <label>Email: <input type="email" {...register("email")}/></label><br/>
                        <label>Hasło: <input type="password" {...register("password")}/></label><br/>
                        <label>Uprawnienia (podawać po przecinku bez spacji): </label>
                        <select {...register("role")}>
                            <option value={RolesEnum.USER}>Użytkownik</option>
                            <option value={RolesEnum.ADMIN}>Admin</option>
                        </select>
                        <br/>
                        <label>Avatar: <input type="file" {...register('profile.avatar')}/></label><br/>
                        <button type="submit" className={styles.button}>Zapisz</button>
                    </form>
                </div>
            </>}

        </LoggedContainer>
    )
}

export {AdminUserEdit}