import React from 'react';
import Http from './http';
import { useState, useEffect } from 'react';
import {createRoot}  from "react-dom/client";
import { createElement } from "react";
export default function App() {
    const [images, setImages] = useState([]);
    const [breeds, setBreeds] = useState([]);
    const [selectedBreed, setSelectedBreed] = useState("");
    const [selectedSubBreed, setSelectedSubBreed] = useState("");
    const [error, setError] = useState("");
    const [subBreeds, setSubBreeds] = useState([]);
    const [allBreedsData, setAllBreedsData] = useState(null);
    const [noOfImages, setNoOfImages] = useState(0);

    useEffect(() => {

        getBreeds();

    }, [])

    useEffect(() => {
        setSelectedSubBreed("");


        if(selectedBreed !== ""){
            getSubBreeds();
        }else{
            setSubBreeds([]);
        }

    }, [selectedBreed])

    const getBreeds = async() => {
        await Http.get('/breeds/list/all')
            .then(response => {
               let data = response.data.message;
               setAllBreedsData(data);
               let keys = Object.keys(data);
                keys.unshift("");
                setBreeds(keys);
            }).catch(err => {
                console.warn('', err);
            });
    };

    const getSubBreeds = async() => {
        if (allBreedsData && (selectedBreed in allBreedsData)){
            if(allBreedsData[selectedBreed] && allBreedsData[selectedBreed] .length > 0){
                let data = allBreedsData[selectedBreed];
                data.unshift("");
                setSubBreeds(data);
            } else {
                setSubBreeds([]);
            }
        }
    };

    const getImages = async() => {
        setImages([]);

        if(noOfImages == 0){
            setError('Please select a number of images');
            return;
        }

        let url = selectedBreed ? '/breed/'+selectedBreed+'/images/random/' : '/breeds/image/random/'

        if (selectedSubBreed) {
            url = 'breed/'+selectedBreed+'/'+selectedSubBreed+'/images/random/'
        }

        setError("");

        await Http.get(url + noOfImages)
            .then(response => {
                setImages(response.data.message);
            }).catch(err => {
                console.warn('', err);
            });
    };

    const renderNumericOptions = () => {
        let op = [];
        for (let i = 0; i <= 10; i++) {
            op.push(<option value={i} key={i}>{i}</option>);
        }
        return op;
    };


    const viewImages = () => {
        getImages();
    };


    return (
        <div>
            <table style={{ width: "60%"}}>
                <tbody>
                <tr>
                    <th>
                        Breed:<br />
                        {<select onChange={(e) => setSelectedBreed(e.target.value)}>{breeds.map((val, i) => <option key={i} value={val}>{val}</option>)}</select>}
                    </th>
                    <th>
                        Sub Breed:<br />
                        {subBreeds.length > 0 && <select onChange={(e) => setSelectedSubBreed(e.target.value)}>{subBreeds.map((val, i) => <option key={i} value={val}>{val}</option>)}</select>}
                    </th>
                    <th>
                        No of images:<br />
                        <select
                            style={ error != "" ? { border: "5px solid red"} : {}}
                            onChange={(e) => setNoOfImages(e.target.value)}
                        >
                            {renderNumericOptions()}
                        </select>
                    </th>
                    <th>
                        <button onClick={viewImages}>View Images</button>

                    </th>
                </tr>
                <tr>
                    <td colSpan={4} style={{color:'red',fontWeight:'bold'}}>
                        {error != "" && error}
                    </td>
                </tr>
                <tr>
                    <td colSpan={4}>
                        {images.map((img) =>(
                            <img key={Math.random()} src={img}  style={{ width: "250px" }}/>
                        ))}
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    );
}

if (document.getElementById('react-app')) {
    const appBox =  document.getElementById('react-app');
    const root = createRoot(appBox);
    root.render(createElement(App, {}));
}
