import styles from "../styles/Navbar.module.css"
import {Link, useNavigate} from "react-router";
import {useState} from "react";
import {useDispatch, useSelector} from "react-redux";
import {resetUser} from "../store/userSlice.ts";
import {resetAuth} from "../store/authSlice.ts";
import {RootState} from "../store/store.ts";
import {RolesEnum} from "../common/enums/RolesEnum.ts";

type Props = {
    children: React.ReactNode;
}

function LoggedContainer({children}: Props) {
    const dispatch = useDispatch()
    const navigate = useNavigate();
    const [isActive, setIsActive] = useState(false);
    const {roles} = useSelector((root: RootState) => root.user)
    const handleHamburger = () => {
        setIsActive(!isActive);
    }

    const _handleLogout = () => {
        dispatch(resetUser())
        dispatch(resetAuth())
        localStorage.clear();

        navigate('/')
    }

    return (
        <>
            <div className={styles.navbar}>
                <div className={styles.logo}>
                    <Link to="/">DateSpark</Link>
                </div>
                <div className={styles.menu}>

                    <Link to="/matches" className={styles.navIcon} title="Dopasowania">
                        <img src="https://img.icons8.com/?size=100&id=18628&format=png&color=ffffff" alt="Dopasowanie"/>
                    </Link>

                    <Link to="/user/profile" className={styles.navIcon} title="Profil użytkownika">
                        <img src="https://img.icons8.com/ios-filled/24/ffffff/user.png" alt="Profil użytkownika"/>
                    </Link>
                    {
                        roles.includes(RolesEnum.ADMIN) &&
                        <Link to="/admin/users" className={styles.navIcon} title="Panel administracyjny">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/settings.png"
                                 alt="Panel administracyjny"/>
                        </Link>
                    }
                    <div className={styles.navIcon} title="Wyloguj" onClick={_handleLogout}>
                        <img src="https://img.icons8.com/ios-filled/24/ffffff/logout-rounded.png" alt="Wyloguj"/>
                    </div>
                </div>
                <div className={styles.hamburger} onClick={handleHamburger}>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div className={`${styles.mobileMenu} ${isActive ? styles.active : ""}`}>
                    <Link to="/Matches">Dopasowania</Link>
                    <Link to="/user/profile">Profil użytkownika</Link>
                    {
                        roles.includes(RolesEnum.ADMIN) &&
                        <Link to="/admin/users" className="admin-panel-mobile">Panel administracyjny</Link>
                    }
                    <span className="logout-mobile" onClick={_handleLogout}>
            Wyloguj
        </span>
                </div>
            </div>
            {children}
        </>
    )
}

export {LoggedContainer};