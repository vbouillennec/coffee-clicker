function Counter(props: { count: number }) {
    return (
        <h1 className="text-8xl font-extrabold dark:text-amber-950">
            {~~props.count} oz
        </h1>
    );
}

export default Counter;
