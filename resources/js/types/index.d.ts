export interface User {
    id: number;
    first_name: string;
	last_name: string;
    email: string;
    email_verified_at?: string;
	status?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
