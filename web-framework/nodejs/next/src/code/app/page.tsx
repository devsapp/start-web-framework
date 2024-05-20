"use client"
import { useState, useEffect } from 'react';

export default function Home() {
  const [data, setData] = useState('');
  const [loading, setLoading] = useState(false);

  const sendRequest = async () => {
    setLoading(true);
    const response = await fetch('/api/hello');
    const data = await response.json();
    setData(data.message);
    setLoading(false);
  };

  useEffect(()=>{
    sendRequest();
  }, [])

  return (
    <main className="flex min-h-screen flex-col items-center justify-between p-24">
      <h1 className="w-full text-center m-4 font-semibold text-lg">
        Full stack example using Next.js
      </h1>
      <div>{loading ? 'loading...' : data}</div>
      <div>
        <button
          onClick={sendRequest}
          className="border-blue-500 bg-blue-500 text-white p-2 px-4 rounded-md"
        >
          Submit
        </button>
      </div>
    </main>
  );
}