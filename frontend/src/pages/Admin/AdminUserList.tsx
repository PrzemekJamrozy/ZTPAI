import {AdminUserListItem} from "../../components/AdminUserListItem.tsx";
import styles from "../../styles/UserProfile.module.css"
import {LoggedContainer} from "../LoggedContainer.tsx";
import {useEffect, useState} from "react";
import {action_admin_get_users} from "../../common/actions/actions.ts";
import {Spinner} from "../../components/Spinner.tsx";
import {UserData} from "../../common/actions/Responses.ts";
import {useToast} from "../../hooks/useToast.tsx";

function AdminUserList() {
    const [loading, setLoading] = useState(true)
    const [users, setUsers] = useState<UserData[]>([]);
    const toast = useToast()

    useEffect(() => {
        const _getUsers = async () => {
            const result = await action_admin_get_users()

            if (result.success) {
                setUsers(result.data)
            }
            else{
                toast("Nie udało pobrać się użytkowników", "error");
            }
            setLoading(false)

        }
        _getUsers()
        document.body.classList.add(styles.userProfileBody)
        return () => {
            document.body.classList.remove(styles.userProfileBody)
        }
    }, [])


    return (
        <LoggedContainer>
            {loading && <Spinner/>}
            {!loading &&
                <div className={styles.container}>
                    {users.map(data => <AdminUserListItem key={data.id} name={data.name} id={data.id} surname={data.surname} avatar={data.profile.avatar}/>)}
                </div>
            }
        </LoggedContainer>
    )
}

export {AdminUserList}