import { Links, Meta } from "./paginate";

export type Borrow = {
    id: number;
    lender: string;
    borrower: string;
    docNumber: string;
    date: string;
};

export type Borrows = {
    data: Borrow[];
    links: Links;
    meta: Meta;
};
