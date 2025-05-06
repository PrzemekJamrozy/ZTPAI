import styles from "../styles/UserProfile.module.css"
import placeholder from "../assets/broken-heart.png"
import {Link} from "react-router";
import {useEffect} from "react";
import {LoggedContainer} from "./LoggedContainer.tsx";
import {useSelector} from "react-redux";
import {RootState} from "../store/store.ts";
import {GenderEnum} from "../common/enums/GenderEnum.ts";
function UserProfile() {

    const user = useSelector((root: RootState) => root.user);

    useEffect(()=>{
        document.body.classList.add(styles.userProfileBody)
        return () =>{
            document.body.classList.remove(styles.userProfileBody)
        }
    },[])

    return (
        <>
            <LoggedContainer>
                <div className={styles.container} id="user-profile">
                    <h1>Profil Użytkownika</h1>
                    <div className={styles.userCard}>
                        <img className="user__profile-avatar" src={placeholder} alt="Avatar"/>
                        <div>
                            <p className="user__profile-name"><strong>Imię: {user.name}</strong></p>
                            <p className="user__profile-surname"><strong>Nazwisko: {user.surname}</strong></p>
                            <p className="user__profile-email"><strong>Email: {user.email}</strong></p>
                            <p className="user__profile-sex"><strong>Płeć: {user.gender === GenderEnum.MALE ? "Mężczyzna" : "Kobieta"}</strong></p>
                            <Link to="/user/edit" className={styles.button}>Edytuj Profil</Link>
                            <a href="#" className={`${styles.button} ${styles.deleteAccount}`}>Usuń Konto</a>
                        </div>
                    </div>
                </div>
            </LoggedContainer>
        </>
    )
}

export {UserProfile}