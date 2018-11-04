package streamcipher;

public class Coding {

    public String[] encode(String[] s, String[] key) {
        String[] out = new String[s.length];
        for (int i = 0; i < s.length; i++) {
            out[i] = encode(s[i], key[i % key.length]);
            //  System.out.println(i + " asd " + key.length );
        }
        return out;
    }

    public String encode(String s, String key) {
        try {
            return keyXor(s, key);
        } catch (Exception ex) {
            System.out.println("Unsupported character set" + ex);
        }
        return " ";
    }

    private String keyXor(String s, String key) {
        int a = Integer.parseInt(s, 2);
        int b = Integer.parseInt(key, 2);
        byte aa = (byte) a;
        byte bb = (byte) b;
        int xor = aa ^ bb;
        //  System.out.println(xor);
        return String.format("%8s", Integer.toBinaryString(xor & 0xFF)).replace(' ', '0');
    }

    public String convertbinToString(String[] array) {

        StringBuilder sb = new StringBuilder();

        for (String array1 : array) {
            if (array1 != null && array1.startsWith("01") && !array1.equals("*")) {
                int decimal = Integer.parseInt(array1, 2);
                sb.append((char) decimal);
            } else {
                sb.append("*");
            }
        }
        return sb.toString();
    }

}
