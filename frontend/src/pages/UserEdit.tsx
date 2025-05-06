import styles from "../styles/UserEdit.module.css"
import {useEffect} from "react";
import {useForm} from "react-hook-form";
import {EditUserForm, EditUserPayload} from "../common/Forms/EditUserForm.ts";
import {LoggedContainer} from "./LoggedContainer.tsx";
import {useToast} from "../hooks/useToast.tsx";
import {action_update_user} from "../common/actions/actions.ts";
import {useDispatch, useSelector} from "react-redux";
import {setUser} from "../store/userSlice.ts";
import {RootState} from "../store/store.ts";
import {PreferredGenderEnum} from "../common/enums/PreferredGenderEnum.ts";
import {useImageEncoder} from "../hooks/useImageEncoder.ts";


function UserEdit() {
    const toast = useToast();
    const dispatch = useDispatch();
    const imageEncoder = useImageEncoder()
    const {profile,email,id} = useSelector((state: RootState) => state.user)
    const {register, handleSubmit} = useForm<EditUserForm>({
        defaultValues: {
            profile:{
                fbLink: profile.fbLink,
                igLink: profile.igLink,
                bio: profile.bio,
                preferredGender: profile.preferredGender,
                avatar: []
            },
            email: email,
            password: "",
        }
    });

    useEffect(() => {
        document.body.classList.add(styles.userEditBody);
        return () => {
            document.body.classList.remove(styles.userEditBody);
        };
    }, []);

    const _handleSubmit = async (data:EditUserForm) => {
        toast("Aktualizowanie danych użytkownika...", "info")
        let avatar: string = ""
        if(data.profile.avatar?.[0]){
            avatar = await imageEncoder(data.profile.avatar?.[0])
        }

        //@ts-ignore
        const payload: EditUserPayload = {...data}
        payload.profile.avatar = avatar
        const result = await action_update_user(id, data)

        if(result.success){
            toast("Zaktualizowano dane użytkownika", "success")
            dispatch(setUser(result.data))
        }else{
            toast("Nie udało się zaktualizować danych użytkownika", "error")
        }
    }

    return (
        <LoggedContainer>
            <div className={styles.container} id="edit-user">
                <h1>Edytuj Użytkownika</h1>
                <form onSubmit={handleSubmit((data) => _handleSubmit(data))}>
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
                    <label>Nowe hasło: <input type="password" {...register("password")}/></label><br/>
                    <label>Avatar: <input type="file" {...register("profile.avatar")}/></label><br/>
                    <button type="submit" className={styles.button}>Zapisz</button>
                </form>
            </div>
        </LoggedContainer>
    )
}

export {
    UserEdit
}