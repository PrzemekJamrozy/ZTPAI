import styles from "../styles/Matches.module.css"

type Props = {
    imageUrl: string,
    name: string,
    surname: string,
    igLink: string,
    fbLink: string
}

function MatchItem({
                       imageUrl,
                       name,
                       surname,
                       igLink,
                       fbLink
                   }: Props) {

    return (
        <>
            <li className={styles.listItem}>
                <img src={imageUrl} alt="Profile Image" className={styles.profileImage}/>
                <div className={styles.profileInfo}>
                    <h3 className={styles.name}>{name} {surname}</h3>
                    <div className={styles.socialLinks}>
                        <a href={igLink} target="_blank" className={styles.socialLink}>Instagram</a>
                        <a href={fbLink} target="_blank" className={styles.socialLink}>Facebook</a>
                    </div>
                </div>
            </li>
        </>
    )
}

export {MatchItem}