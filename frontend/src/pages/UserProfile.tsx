import styles from "../styles/UserProfile.module.css"
import {Link, useNavigate} from "react-router";
import {useEffect} from "react";
import {LoggedContainer} from "./LoggedContainer.tsx";
import {useDispatch, useSelector} from "react-redux";
import {RootState} from "../store/store.ts";
import {GenderEnum} from "../common/enums/GenderEnum.ts";
import {action_delete_user} from "../common/actions/actions.ts";
import {useToast} from "../hooks/useToast.tsx";
import {resetUser} from "../store/userSlice.ts";
import {resetAuth} from "../store/authSlice.ts";

function UserProfile() {

    const user = useSelector((root: RootState) => root.user);
    const toast = useToast();
    const dispatch = useDispatch();
    const navigate = useNavigate()
    useEffect(() => {
        document.body.classList.add(styles.userProfileBody)
        return () => {
            document.body.classList.remove(styles.userProfileBody)
        }
    }, [])

    const _handleUserDelete = async () => {
        toast("Usuwanie użytkownika...", "info")
        const result = await action_delete_user(user.id)

        if (result.success) {
            dispatch(resetUser())
            dispatch(resetAuth())
            localStorage.clear()
            toast("Pomyślnie usunięto użytkownika")
            navigate("/")
        } else {
            toast("Nie udało się usunąć użytkownika", "error")
        }
    }
    return (
        <>
            <LoggedContainer>
                <div className={styles.container} id="user-profile">
                    <h1>Profil Użytkownika</h1>
                    <div className={styles.userCard}>
                        <img className="user__profile-avatar" src={user.profile.avatar} alt="Avatar"/>
                        <div>
                            <p className="user__profile-name"><strong>Imię: {user.name}</strong></p>
                            <p className="user__profile-surname"><strong>Nazwisko: {user.surname}</strong></p>
                            <p className="user__profile-email"><strong>Email: {user.email}</strong></p>
                            <p className="user__profile-sex">
                                <strong>Płeć: {user.gender === GenderEnum.MALE ? "Mężczyzna" : "Kobieta"}</strong></p>
                            <Link to="/user/edit" className={styles.button}>Edytuj Profil</Link>
                            <button className={`${styles.button} ${styles.deleteAccount}`} onClick={_handleUserDelete}>
                                <span style={{fontSize:16}}>Usuń Konto</span>
                            </button>
                        </div>
                    </div>
                </div>
            </LoggedContainer>
        </>
    )
}

export {UserProfile}