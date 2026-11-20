import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function MoziCrud() {
    const [mozik, setMozik] = useState([]);
    const [loading, setLoading] = useState(true);
    const [success, setSuccess] = useState(null);
    const [error, setError] = useState(null);
    const [errors, setErrors] = useState({});
    const [editingId, setEditingId] = useState(null);
    const [formData, setFormData] = useState({
        nev: '',
        iranyitoszam: '',
        cim: '',
        telefon: '',
    });

    const loadMozik = async () => {
        try {
            const response = await axios.get('/react/mozik');
            setMozik(response.data);
        } catch (err) {
            setError('Nem sikerült betölteni a mozikat.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        loadMozik();
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const resetForm = () => {
        setFormData({
            nev: '',
            iranyitoszam: '',
            cim: '',
            telefon: '',
        });
        setEditingId(null);
        setErrors({});
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSuccess(null);
        setError(null);
        setErrors({});

        try {
            if (editingId) {
                await axios.put(`/react/mozik/${editingId}`, formData);
                setSuccess('A mozi adatai sikeresen frissítve.');
            } else {
                await axios.post('/react/mozik', formData);
                setSuccess('Az új mozi sikeresen hozzáadva.');
            }
            resetForm();
            loadMozik();
        } catch (err) {
            if (err.response && err.response.status === 422) {
                setErrors(err.response.data.errors || {});
            } else {
                setError('Hiba történt a mentés során.');
            }
        }
    };

    const handleEdit = (mozi) => {
        setEditingId(mozi.id);
        setFormData({
            nev: mozi.nev || '',
            iranyitoszam: String(mozi.iranyitoszam || ''),
            cim: mozi.cim || '',
            telefon: mozi.telefon || '',
        });
        setSuccess(null);
        setError(null);
        setErrors({});
    };

    const handleCancel = () => {
        resetForm();
    };

    const handleDelete = async (id) => {
        if (!window.confirm('Biztosan törölni szeretnéd ezt a mozit?')) {
            return;
        }

        setSuccess(null);
        setError(null);

        try {
            await axios.delete(`/react/mozik/${id}`);
            setSuccess('A mozi sikeresen törölve.');
            if (editingId === id) {
                resetForm();
            }
            loadMozik();
        } catch (err) {
            setError('Hiba történt a törlés során.');
        }
    };

    return (
        <div>
            <h1 className="h3 mb-3">Mozik kezelése (React)</h1>

            {success && <div className="alert alert-success">{success}</div>}
            {error && <div className="alert alert-danger">{error}</div>}

            <div className="card mb-4">
                <div className="card-header">{editingId ? 'Mozi szerkesztése' : 'Új mozi hozzáadása'}</div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="nev" className="form-label">Név</label>
                            <input
                                type="text"
                                className={`form-control ${errors.nev ? 'is-invalid' : ''}`}
                                id="nev"
                                name="nev"
                                value={formData.nev}
                                onChange={handleChange}
                            />
                            {errors.nev && <div className="invalid-feedback">{errors.nev[0]}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="iranyitoszam" className="form-label">Irányítószám</label>
                            <input
                                type="text"
                                className={`form-control ${errors.iranyitoszam ? 'is-invalid' : ''}`}
                                id="iranyitoszam"
                                name="iranyitoszam"
                                value={formData.iranyitoszam}
                                onChange={handleChange}
                            />
                            {errors.iranyitoszam && <div className="invalid-feedback">{errors.iranyitoszam[0]}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="cim" className="form-label">Cím</label>
                            <input
                                type="text"
                                className={`form-control ${errors.cim ? 'is-invalid' : ''}`}
                                id="cim"
                                name="cim"
                                value={formData.cim}
                                onChange={handleChange}
                            />
                            {errors.cim && <div className="invalid-feedback">{errors.cim[0]}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="telefon" className="form-label">Telefon</label>
                            <input
                                type="text"
                                className={`form-control ${errors.telefon ? 'is-invalid' : ''}`}
                                id="telefon"
                                name="telefon"
                                value={formData.telefon}
                                onChange={handleChange}
                            />
                            {errors.telefon && <div className="invalid-feedback">{errors.telefon[0]}</div>}
                        </div>

                        <button type="submit" className="btn btn-primary me-2">
                            {editingId ? 'Módosítás mentése' : 'Hozzáadás'}
                        </button>
                        {editingId && (
                            <button type="button" className="btn btn-outline-secondary" onClick={handleCancel}>
                                Mégse
                            </button>
                        )}
                    </form>
                </div>
            </div>

            <div className="card">
                <div className="card-header">Mozik listája</div>
                <div className="card-body">
                    {loading ? (
                        <p>Betöltés...</p>
                    ) : (
                        <div className="table-responsive">
                            <table className="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Név</th>
                                        <th>Irányítószám</th>
                                        <th>Cím</th>
                                        <th>Telefon</th>
                                        <th>Műveletek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {mozik.map((mozi) => (
                                        <tr key={mozi.id}>
                                            <td>{mozi.id}</td>
                                            <td>{mozi.nev}</td>
                                            <td>{mozi.iranyitoszam}</td>
                                            <td>{mozi.cim}</td>
                                            <td>{mozi.telefon || '–'}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    className="btn btn-sm btn-outline-warning me-2"
                                                    onClick={() => handleEdit(mozi)}
                                                >
                                                    Szerkesztés
                                                </button>
                                                <button
                                                    type="button"
                                                    className="btn btn-sm btn-outline-danger"
                                                    onClick={() => handleDelete(mozi.id)}
                                                >
                                                    Törlés
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                    {mozik.length === 0 && (
                                        <tr>
                                            <td colSpan="6" className="text-center text-body-secondary">
                                                Nincs megjeleníthető mozi.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
