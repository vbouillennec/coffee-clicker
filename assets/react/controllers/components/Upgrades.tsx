function Upgrades(props: any) {
    const displayUpgrades = () => {
        return props.upgrades.map((upgrade: any, index: any) => {
            return props.count >= upgrade.price ? (
                <div key={index} className="mb-2">
                    <button
                        disabled={props.count < upgrade.price}
                        className="bg-orange-700 hover:bg-orange-500 text-white font-bold py-2 px-4 border-b-4 border-orange-900 hover:border-orange-700 rounded w-full text-left"
                        onClick={() => props.activeUpgrade(index)}
                    >
                        [{upgrade.count}] {upgrade.name}: {upgrade.price}
                    </button>
                </div>
            ) : (
                <div key={index} className="mb-2">
                    <button
                        disabled={props.count < upgrade.price}
                        className="font-bold py-2 px-4 border-b-4 disabled:bg-slate-500 disabled:text-slate-50 disabled:border-slate-700 disabled:shadow-none rounded w-full text-left"
                        onClick={() => props.activeUpgrade(index)}
                    >
                        [{upgrade.count}] {upgrade.name}: {upgrade.price}
                    </button>
                </div>
            );
        });
    };

    return (
        <>
            <h2 className="text-2xl font-bold dark:text-white">
                Autoclicks : {props.autoclickPerSecond}
            </h2>
            {displayUpgrades()}
        </>
    );
}

export default Upgrades;
