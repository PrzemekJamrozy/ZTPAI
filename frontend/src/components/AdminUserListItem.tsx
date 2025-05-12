import {Link} from "react-router";
import styles from "../styles/UserProfile.module.css"

type AdminUserListItemProps = {
    name: string
    surname: string
    id: number
    avatar: string
    handleUserDelete: (userId:number) => void
}

function AdminUserListItem(props:AdminUserListItemProps) {

    const {
        name,
        surname,
        id,
        avatar,
        handleUserDelete,
    } = props
    return (
        <div className={styles.userCard}>
            <img src={avatar} alt="Avatar"/>
            <div>
                <p><strong>Imię:</strong> {name}</p>
                <p><strong>Nazwisko:</strong> {surname}</p>
                <Link to={`/admin/users/${id}/edit`} className={styles.button}>Edytuj</Link>
                <button className={`${styles.button}`} onClick={() => handleUserDelete(id)}>Usuń</button>
            </div>
        </div>
    )
}

export {AdminUserListItem}