import styles from "../styles/CommonOnboarding.module.css";
import {Link, useNavigate} from "react-router";
import {useEffect} from "react";
import {useForm} from "react-hook-form";
import {GenderEnum} from "../common/enums/GenderEnum.ts";
import {RegisterForm} from "../common/Forms/RegisterForm.ts";
import {action_register} from "../common/actions/actions.ts";
import {useToast} from "../hooks/useToast.tsx";


function RegisterPage() {
    const navigate = useNavigate();
    const toast = useToast();
    const {register, handleSubmit, watch, formState: {errors}} = useForm<RegisterForm>({
        defaultValues: {
            email: "",
            password: "",
            name: "",
            surname: "",
            passwordAgain: "",
            gender: GenderEnum.MALE,
        }
    });

    useEffect(() => {
        document.body.classList.add(styles.commonOnboardingBody);

        return () => {
            document.body.classList.remove(styles.commonOnboardingBody);
        }
    }, [])

    const _handleSubmit = async (data: RegisterForm) => {
        toast("Trwa rejestrowanie", "info")
        const result = await action_register(data)
        if (result.success) {
            toast("Pomyślnie zarejestrowany")
            navigate('/login')
        } else {
            toast("Rejestracja się nie powiodła", "error")
        }
    }

    return (
        <>
            <div className={styles.container}>
                <h1>Rejestracja</h1>
                <form onSubmit={handleSubmit((data) => _handleSubmit(data))}>
                    <div className={styles.formGroup}>
                        <label htmlFor="name">Imię</label>
                        <input type="text" id="name" {...register('name')} placeholder="Wpisz swoje imię" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="surname">Nazwisko</label>
                        <input type="text" id="surname" {...register('surname')} placeholder="Wpisz swoje nazwisko"
                               required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="email">Email</label>
                        <input type="email" id="email" {...register('email')} placeholder="Wpisz swój email" required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="password">Hasło</label>
                        <input type="password" id="password" {...register('password')} placeholder="Wpisz hasło"
                               required/>
                    </div>
                    <div className={styles.formGroup}>
                        <label htmlFor="password-again">Powtórz hasło</label>
                        <input type="password" id="password-again" {...register('passwordAgain', {
                            validate: (val: string) => {
                                if (watch('password') != val){
                                    return "Password doesn't match"
                                }
                            }
                        })} placeholder="Powtórz hasło"
                               required/>
                        <span style={{color:'red'}}>{errors.passwordAgain && errors.passwordAgain.message}</span>
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