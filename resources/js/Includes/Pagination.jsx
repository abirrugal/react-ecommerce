import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function Pagination({ links }) {

    function getClassName(active) {
        if (active) {
            return "page-item active";
        } else {
            return "page-item";
        }
    }
    function getLabelName(label) {
        if (label == "&laquo; Previous") {
            return "Previous"
        }
        if (label == "Next &raquo;") {
            return "Next"
        }
        return label;

    }
    return (
        links.length > 3 && (
            <div className="mb-4">
                <div className="flex flex-wrap mt-8">
                    <nav aria-label="Page navigation example">
                        <ul className="pagination">
                            {links.map((link, key) => (
                                link.url === null ?
                                
                                    (<li key={key} className="page-item disabled">
                                        <a className="page-link" href="#" tabIndex="-1">{getLabelName(link.label)}</a>
                                    </li> ) :
                                    (
                                    <li key={key} className={getClassName(link.active)}><Link className="page-link" href={link.url}>{getLabelName(link.label)}</Link></li>
                                    )
                            ))}
                        </ul>
                    </nav>
                </div>
            </div>
        )
    );
}