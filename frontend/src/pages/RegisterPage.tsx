import styles from "../styles/CommonOnboarding.module.css";
import {Link} from "react-router";
import {useEffect} from "react";
import {useForm} from "react-hook-form";
import {GenderEnum} from "../common/enums/GenderEnum.ts";
import {RegisterForm} from "../common/Forms/RegisterForm.ts";
import {action_register} from "../common/actions/actions.ts";



function RegisterPage() {

    const {register, handleSubmit} = useForm<RegisterForm>({
        defaultValues: {
            email:"",
            password:"",
            name:"",
            surname:"",
            passwordAgain:"",
            gender:GenderEnum.MALE,
        }
    });

    useEffect(()=>{
       document.body.classList.add(styles.commonOnboardingBody);

       return () => {
           document.body.classList.remove(styles.commonOnboardingBody);
       }
    },[])

    return(
        <>
            <div className={styles.container}>
                <h1>Rejestracja</h1>
                <form onSubmit={handleSubmit((data)=> action_register(data))}>
                    <div className={styles.formGroup}>
                        <label htmlFor="name">Imię</label>
                        <input type="text" id="name" {...register('name')} placeholder="Wpisz swoje imię" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="surname">Nazwisko</label>
                        <input type="text" id="surname" {...register('surname')} placeholder="Wpisz swoje nazwisko" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="email">Email</label>
                        <input type="email" id="email" {...register('email')} placeholder="Wpisz swój email" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="password">Hasło</label>
                        <input type="password" id="password" {...register('password')} placeholder="Wpisz hasło" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="password-again">Powtórz hasło</label>
                        <input type="password" id="password-again" {...register('passwordAgain')} placeholder="Powtórz hasło"
                               required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="gender">Płeć</label>
                        <select id="gender" {...register('gender')} required>
                            <option value={GenderEnum.MALE}>Mężczyzna</option>
                            <option value={GenderEnum.FEMALE}>Kobieta</option>
                        </select>
                    </div>
                    <button type="submit" className={styles.btnSubmit}>Zarejestruj się</button>
                </form>
                <p>Masz już konto? <Link to="/login">Zaloguj się</Link></p>
            </div>
        </>
    )

}

export {RegisterPage};