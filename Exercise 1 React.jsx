import { useState } from "react";

const NAME_COUNT = 10;

function makeEmptyNames() {
  return Array.from({ length: NAME_COUNT }, () => ({ first: "", last: "" }));
}

function shuffleArray(items) {
  const copy = [...items];
  for (let i = copy.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [copy[i], copy[j]] = [copy[j], copy[i]];
  }
  return copy;
}

function asciiTotal(text) {
  let total = 0;
  for (let i = 0; i < text.length; i++) {
    total += text.charCodeAt(i);
  }
  return total;
}

function isInOrder(first, last) {
  return first.toLowerCase() <= last.toLowerCase();
}

export default function NameMixer() {
  const [names, setNames] = useState(makeEmptyNames());
  const [error, setError] = useState("");
  const [mixedNames, setMixedNames] = useState([]);

  function handleChange(index, field, value) {
    const updatedNames = names.map((name, i) =>
      i === index ? { ...name, [field]: value } : name
    );
    setNames(updatedNames);
  }

  function handleSubmit(event) {
    event.preventDefault();

    const hasBlank = names.some(
      (name) => name.first.trim() === "" || name.last.trim() === ""
    );
    if (hasBlank) {
      setError("Please enter all 10 first and last names.");
      setMixedNames([]);
      return;
    }

    setError("");
    const firstNames = shuffleArray(names.map((name) => name.first.trim()));
    const lastNames = shuffleArray(names.map((name) => name.last.trim()));
    setMixedNames(
      firstNames.map((first, i) => ({ first, last: lastNames[i] }))
    );
  }

  const orderedNames = mixedNames.filter((name) =>
    isInOrder(name.first, name.last)
  );

  return (
    <div style={{ fontFamily: "sans-serif", padding: "1rem" }}>
      <h2>Enter 10 Names</h2>
      {error !== "" && <p style={{ color: "red" }}>{error}</p>}

      <form onSubmit={handleSubmit}>
        <table>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
            </tr>
          </thead>
          <tbody>
            {names.map((name, i) => (
              <tr key={i}>
                <td>
                  <input
                    type="text"
                    value={name.first}
                    onChange={(e) => handleChange(i, "first", e.target.value)}
                  />
                </td>
                <td>
                  <input
                    type="text"
                    value={name.last}
                    onChange={(e) => handleChange(i, "last", e.target.value)}
                  />
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        <br />
        <button type="submit">Submit</button>
      </form>

      {mixedNames.length > 0 && (
        <div>
          <h2>Random Names</h2>
          <table border="1" cellPadding="5">
            <tbody>
              {mixedNames.map((name, i) => (
                <tr key={i}>
                  <td>{name.first}</td>
                  <td>{name.last}</td>
                </tr>
              ))}
            </tbody>
          </table>

          <h2>Names in Alphabetical Order</h2>
          <table border="1" cellPadding="5">
            <tbody>
              {orderedNames.map((name, i) => (
                <tr key={i}>
                  <td>{name.first}</td>
                  <td>{name.last}</td>
                </tr>
              ))}
            </tbody>
          </table>

          <h2>Last Names with ASCII Totals</h2>
          <table border="1" cellPadding="5">
            <tbody>
              {mixedNames.map((name, i) => (
                <tr key={i}>
                  <td>{name.last}</td>
                  <td>{asciiTotal(name.last)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
