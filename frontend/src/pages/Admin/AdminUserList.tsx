import {useEffect} from "react";
import {AdminUserListItem} from "../../components/AdminUserListItem.tsx";
import styles from "../../styles/UserProfile.module.css"
import placeholder from "../../assets/broken-heart.png"
function AdminUserList() {

    useEffect(()=>{
        document.body.classList.add(styles.userProfileBody)
        return () =>{
            document.body.classList.remove(styles.userProfileBody)
        }
    },[])


    return (
        <>
            <div className={styles.container}>
                <AdminUserListItem userName={"1"} userAvatar={placeholder} userId={1} userSurname={"surname"} />
            </div>
        </>
    )
}

export {AdminUserList}