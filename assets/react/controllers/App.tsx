import "./App.css";
import { setInterval, clearInterval } from "worker-timers";
// import ClickMeButton from "./components/ClickMeButton"
import Counter from "./components/Counter";
import RightSide from "./components/RightSide";
import { useEffect, useState } from "react";
import LeftSide from "./components/LeftSide";
import { Upgrade } from "./interfaces/Upgrade";
import { Power } from "./interfaces/Power";
import anime from "animejs";
import CoffeeLineUp from "./components/CoffeeCup/CoffeeLineUp";

function App() {
    const [count, setCount] = useState<number>(0);
    const [clickDamage, setClickDamage] = useState<number>(1);
    const [autoclickPerSecond, setAutoclickPerSecond] = useState<number>(0);
    const [upgrades, setUpgrades] = useState<Upgrade[]>([
        {
            name: "Auto clicker",
            price: 10,
            clickRates: 1,
            count: 0
        },
        {
            name: "Personnal assistant",
            price: 50,
            clickRates: 10,
            count: 0
        }
    ]);
    const [powers, setPowers] = useState<Power[]>([
        {
            name: "Click damage",
            price: 10,
            priceMultiplier: 10,
            damage: 1,
            count: 0
        }
    ]);

    const popClickMe = anime({
        targets: "#click-me-button",
        scale: 1.5,
        duration: 100,
        easing: "easeInOutQuad",
        direction: "alternate"
    });

    useEffect(() => {
        const triggerAutoClickers = () => {
            setCount(count + autoclickPerSecond / 10);
        };

        const intervalId = setInterval(triggerAutoClickers, 100);

        document.title = `You've earned ${~~count} clicks!`;

        return () => {
            clearInterval(intervalId);
        };
    }, [autoclickPerSecond, count, upgrades]);

    const handleClick = () => {
        popClickMe.restart();
        setCount(count + clickDamage);
    };

    const activeUpgrade = (index: number) => {
        let costPrice = 0;
        let countAutoclickPerSecond = 0;
        const updatedUpgrades = upgrades.map((upgrade, i: number) => {
            if (i === index) {
                costPrice = upgrade.price;
                upgrade.count++;
                upgrade.price = Math.floor(upgrade.price * 1.2);
            }
            countAutoclickPerSecond =
                countAutoclickPerSecond + upgrade.clickRates * upgrade.count;
            return upgrade;
        });
        setAutoclickPerSecond(countAutoclickPerSecond);
        setUpgrades(updatedUpgrades);
        setCount(count - costPrice);
    };

    const activePower = (index: number) => {
        let costPrice = 0;
        let powerDamage = 0;
        const updatedPowers = powers.map((power, i: number) => {
            if (i === index) {
                costPrice = power.price;
                powerDamage = power.damage;
                power.damage = power.damage * 4;
                power.count++;
                power.price = power.price * power.priceMultiplier;
            }
            return power;
        });
        setPowers(updatedPowers);
        setCount(count - costPrice);
        setClickDamage(clickDamage + powerDamage);
    };

    return (
        <>
            <LeftSide
                count={count}
                powers={powers}
                activePower={activePower}
                clickDamage={clickDamage}
            />
            <RightSide
                count={count}
                upgrades={upgrades}
                activeUpgrade={activeUpgrade}
                autoclickPerSecond={autoclickPerSecond}
            />
            <main
                className="
                flex 
                min-h-screen 
                flex-col 
                items-center 
                justify-center 
                gap-12 p-24
              "
            >
                <Counter count={count} />
                <CoffeeLineUp handleClick={handleClick} />
                {/* <ClickMeButton handleClick={handleClick} /> */}
            </main>
        </>
    );
}

export default App;
